export default function StructuredData() {
  const structuredData = {
    "@context": "https://schema.org",
    "@type": "Person",
    name: "Stanley Owen",
    jobTitle: "Full Stack Developer",
    description:
      "Passionate about building elegant solutions and creating meaningful digital experiences. I enjoy developing cross-platform applications, combining modern UI design with high-performance systems programming.",
    url: "https://stanleyowen.com",
    image: "https://github.com/stanleyowen.png",
    sameAs: [
      "https://github.com/stanleyowen",
      "https://linkedin.com/in/stanley-owen",
      "https://www.instagram.com/stanleyowennn",
    ],
    knowsAbout: [
      "Full Stack Development",
      "React",
      "Next.js",
      "TypeScript",
      "JavaScript",
      "Node.js",
      "MongoDB",
      "Software Engineering",
      "Web Development",
    ],
    alumniOf: [
      {
        "@type": "Organization",
        name: "National Taiwan University of Science and Technology",
      },
      {
        "@type": "Organization",
        name: "SMA Sutomo 1",
      },
    ],
  };

  return (
    <script
      type="application/ld+json"
      dangerouslySetInnerHTML={{ __html: JSON.stringify(structuredData) }}
    />
  );
}
