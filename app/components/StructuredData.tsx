export default function StructuredData() {
  const structuredData = {
    "@context": "https://schema.org",
    "@type": "Person",
    name: "Stanley Owen",
    jobTitle: "Software Engineer",
    description:
      "Computer Science student at NTUST in Taipei, building mobile and cross-platform apps, AI systems, and open-source software.",
    url: "https://stanleyowen.com",
    image: "https://stanleyowen.com/profile.jpg",
    sameAs: [
      "https://github.com/stanleyowen",
      "https://linkedin.com/in/stanley-owen",
    ],
    knowsAbout: [
      "Software Engineering",
      "Full Stack Development",
      "React",
      "Electron",
      "TypeScript",
      "JavaScript",
      "Python",
      "Node.js",
      "MongoDB",
      "Natural Language Processing",
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
