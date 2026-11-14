import { NextRequest, NextResponse } from "next/server";
import nodemailer from "nodemailer";

const RECIPIENT = "me@stanleyowen.com";
const MAX_BODY_BYTES = 16 * 1024;
const LIMITS = { name: 100, email: 254, subject: 200, message: 5000 } as const;
const EMAIL_REGEX = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

const smtpPort = Number(process.env.SMTP_PORT) || 587;

// Created once per server instance rather than on every request.
const transporter = nodemailer.createTransport({
  host: process.env.SMTP_HOST || "smtp.gmail.com",
  port: smtpPort,
  secure: smtpPort === 465, // implicit TLS on 465, STARTTLS otherwise
  auth: {
    user: process.env.SMTP_USER,
    pass: process.env.SMTP_PASS,
  },
});

const HTML_ESCAPES: Record<string, string> = {
  "&": "&amp;",
  "<": "&lt;",
  ">": "&gt;",
  '"': "&quot;",
  "'": "&#39;",
};

function escapeHtml(value: string) {
  return value.replace(/[&<>"']/g, (ch) => HTML_ESCAPES[ch]);
}

function error(message: string, status = 400) {
  return NextResponse.json({ error: message }, { status });
}

async function verifyTurnstile(token: string, ip: string | null) {
  const secret = process.env.TURNSTILE_SECRET_KEY;
  if (!secret) {
    console.error("TURNSTILE_SECRET_KEY is not configured");
    return false;
  }

  const res = await fetch(
    "https://challenges.cloudflare.com/turnstile/v0/siteverify",
    {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        secret,
        response: token,
        ...(ip && { remoteip: ip }),
      }),
      signal: AbortSignal.timeout(5000),
    },
  );
  const data = (await res.json()) as { success?: boolean };
  return data.success === true;
}

export async function POST(request: NextRequest) {
  try {
    if (Number(request.headers.get("content-length")) > MAX_BODY_BYTES) {
      return error("Request too large", 413);
    }

    let body: unknown;
    try {
      body = await request.json();
    } catch {
      return error("Invalid request body");
    }
    if (!body || typeof body !== "object") {
      return error("Invalid request body");
    }

    const raw = body as Record<string, unknown>;
    const fields = {
      name: raw.name,
      email: raw.email,
      subject: raw.subject,
      message: raw.message,
    };

    // Validate required fields: must be non-empty strings within length limits
    for (const [key, value] of Object.entries(fields)) {
      if (typeof value !== "string" || !value.trim()) {
        return error("All fields are required");
      }
      if (value.length > LIMITS[key as keyof typeof LIMITS]) {
        return error(`The ${key} field is too long`);
      }
    }

    const name = (fields.name as string).trim().replace(/[\r\n]+/g, " ");
    const email = (fields.email as string).trim();
    const subject = (fields.subject as string).trim().replace(/[\r\n]+/g, " ");
    const message = (fields.message as string).trim();

    if (!EMAIL_REGEX.test(email)) {
      return error("Invalid email format");
    }

    // Verify Turnstile token last among the checks so malformed requests
    // don't cost a round trip to Cloudflare.
    const turnstileToken = raw.turnstileToken;
    if (typeof turnstileToken !== "string" || !turnstileToken) {
      return error("Please complete the verification");
    }
    const ip =
      request.headers.get("cf-connecting-ip") ??
      request.headers.get("x-forwarded-for")?.split(",")[0].trim() ??
      null;
    if (!(await verifyTurnstile(turnstileToken, ip))) {
      return error("Verification failed. Please try again.");
    }

    const safe = {
      name: escapeHtml(name),
      email: escapeHtml(email),
      subject: escapeHtml(subject),
      message: escapeHtml(message),
    };

    await transporter.sendMail({
      from: process.env.SMTP_FROM || RECIPIENT,
      to: RECIPIENT,
      subject: `Contact Form: ${subject}`,
      replyTo: { name, address: email },
      html: `
        <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
          <h2 style="color: #333; border-bottom: 2px solid #eee; padding-bottom: 10px;">
            New Contact Form Submission
          </h2>

          <div style="background: #f9f9f9; padding: 20px; border-radius: 8px; margin: 20px 0;">
            <p><strong>Name:</strong> ${safe.name}</p>
            <p><strong>Email:</strong> ${safe.email}</p>
            <p><strong>Subject:</strong> ${safe.subject}</p>
          </div>

          <div style="margin: 20px 0;">
            <h3 style="color: #333; margin-bottom: 10px;">Message:</h3>
            <div style="background: white; padding: 15px; border-left: 4px solid #007cba; white-space: pre-wrap;">${safe.message}</div>
          </div>

          <hr style="margin: 30px 0; border: none; border-top: 1px solid #eee;">

          <p style="color: #666; font-size: 12px;">
            This message was sent from your portfolio website contact form.<br>
            You can reply directly to this email to respond to ${safe.name}.
          </p>
        </div>
      `,
      text: `
New Contact Form Submission

Name: ${name}
Email: ${email}
Subject: ${subject}

Message:
${message}

---
This message was sent from your portfolio website contact form.
You can reply directly to this email to respond to ${name}.
      `,
    });

    return NextResponse.json(
      { message: "Email sent successfully" },
      { status: 200 },
    );
  } catch (err) {
    console.error("Contact form error:", err);
    return error("Failed to send email. Please try again later.", 500);
  }
}
