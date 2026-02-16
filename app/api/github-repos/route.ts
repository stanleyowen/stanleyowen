import { NextResponse } from "next/server";
import { Octokit } from "@octokit/rest";

export interface GitHubRepo {
  id: number;
  name: string;
  full_name: string;
  description: string | null;
  html_url: string;
  homepage: string | null;
  stargazers_count: number;
  forks_count: number;
  language: string | null;
  topics: string[];
  created_at: string;
  updated_at: string;
  pushed_at: string;
  private: boolean;
}

export async function GET() {
  try {
    const token = process.env.GITHUB_TOKEN;

    if (!token) {
      return NextResponse.json(
        { error: "GitHub token not configured" },
        { status: 500 },
      );
    }

    const octokit = new Octokit({ auth: token });

    // Fetch all repos (including private ones with authentication)
    const { data: allRepos } = await octokit.repos.listForAuthenticatedUser({
      per_page: 100,
      sort: "updated",
      direction: "desc",
    });

    // Only show repos with "portfolio" topic - you control this in GitHub repo settings
    // This way you explicitly choose which repos to display
    const featuredRepos = allRepos.filter(
      (repo) =>
        repo.topics?.includes("portfolio") && !repo.fork && !repo.archived,
    );

    return NextResponse.json(featuredRepos, {
      headers: {
        "Cache-Control": "s-maxage=3600, stale-while-revalidate",
      },
    });
  } catch (error) {
    console.error("Error fetching GitHub repos:", error);
    return NextResponse.json(
      { error: "Failed to fetch repositories" },
      { status: 500 },
    );
  }
}
