export default function StructuredData({
  description,
  url,
}: {
  description: string;
  url: string;
}) {
  const structuredData = {
    "@context": "https://schema.org",
    "@type": "Person",
    name: "Stanley Owen",
    alternateName: "張銘元",
    jobTitle: "Software Engineer",
    description,
    url,
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
    ],
  };

  return (
    <script
      type="application/ld+json"
      dangerouslySetInnerHTML={{ __html: JSON.stringify(structuredData) }}
    />
  );
}
