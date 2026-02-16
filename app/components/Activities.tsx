"use client";

import { useState } from "react";
import activitiesData from "../data/activities.json";

interface Activity {
  id: number;
  title: string;
  organization: string;
  type: "work" | "achievement" | "project" | "volunteer";
  period: string;
  location: string;
  description: string;
  details: string[];
  skills: string[];
  icon: string;
}

export default function Activities() {
  const [selectedActivity, setSelectedActivity] = useState<Activity | null>(
    null,
  );
  const activities = activitiesData as Activity[];

  const getTypeColor = (type: Activity["type"]) => {
    const colors = {
      work: "bg-blue-200 text-blue-800 dark:bg-blue-500/20 dark:text-blue-300",
      achievement:
        "bg-yellow-200 text-yellow-800 dark:bg-yellow-500/20 dark:text-yellow-300",
      project:
        "bg-purple-200 text-purple-800 dark:bg-purple-500/20 dark:text-purple-300",
      volunteer:
        "bg-green-200 text-green-800 dark:bg-green-500/20 dark:text-green-300",
    };
    return colors[type];
  };

  const getTypeLabel = (type: Activity["type"]) => {
    const labels = {
      work: "Work Experience",
      achievement: "Achievement",
      project: "Project",
      volunteer: "Volunteer",
    };
    return labels[type];
  };

  return (
    <>
      <section className="relative z-10 w-full py-20 px-8">
        <div className="max-w-6xl mx-auto">
          <h2 className="text-3xl font-bold text-center mb-12 text-black dark:text-white">
            Activities & Experience
          </h2>

          <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
            {activities.map((activity) => (
              <div
                key={activity.id}
                onClick={() => setSelectedActivity(activity)}
                className="bg-white/60 dark:bg-white/5 backdrop-blur-sm border-2 border-zinc-300 dark:border-white/10 rounded-lg p-6 hover:bg-white/80 dark:hover:bg-white/10 transition-all hover:scale-105 cursor-pointer"
              >
                {/* Icon & Type Badge */}
                <div className="flex items-start justify-between mb-3">
                  <span className="text-4xl">{activity.icon}</span>
                  <span
                    className={`px-3 py-1 rounded-full text-xs font-medium ${getTypeColor(
                      activity.type,
                    )}`}
                  >
                    {getTypeLabel(activity.type)}
                  </span>
                </div>

                {/* Title */}
                <h3 className="text-xl font-bold text-black dark:text-white mb-2">
                  {activity.title}
                </h3>

                {/* Organization & Location */}
                <div className="flex items-center gap-2 text-sm text-zinc-600 dark:text-zinc-400 mb-2">
                  <span className="font-medium">{activity.organization}</span>
                  <span>•</span>
                  <span>{activity.location}</span>
                </div>

                {/* Period */}
                <div className="text-sm text-zinc-600 dark:text-zinc-400 mb-3">
                  📅 {activity.period}
                </div>

                {/* Description */}
                <p className="text-zinc-700 dark:text-zinc-300 text-sm mb-4 line-clamp-2">
                  {activity.description}
                </p>

                {/* Skills Preview */}
                <div className="flex flex-wrap gap-2">
                  {activity.skills.slice(0, 3).map((skill, index) => (
                    <span
                      key={index}
                      className="px-2 py-1 bg-zinc-200 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 rounded text-xs"
                    >
                      {skill}
                    </span>
                  ))}
                  {activity.skills.length > 3 && (
                    <span className="px-2 py-1 text-zinc-600 dark:text-zinc-400 text-xs">
                      +{activity.skills.length - 3} more
                    </span>
                  )}
                </div>

                {/* Click hint */}
                <div className="mt-4 text-xs text-zinc-500 dark:text-zinc-500 text-center">
                  Click for details →
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Modal Dialog */}
      {selectedActivity && (
        <div
          className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
          onClick={() => setSelectedActivity(null)}
        >
          <div
            className="bg-white dark:bg-zinc-900 rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto shadow-2xl"
            onClick={(e) => e.stopPropagation()}
          >
            {/* Modal Header */}
            <div className="sticky top-0 bg-white dark:bg-zinc-900 border-b-2 border-zinc-200 dark:border-zinc-800 p-6">
              <div className="flex items-start justify-between">
                <div className="flex items-center gap-4">
                  <span className="text-5xl">{selectedActivity.icon}</span>
                  <div>
                    <h3 className="text-2xl font-bold text-black dark:text-white mb-1">
                      {selectedActivity.title}
                    </h3>
                    <p className="text-zinc-600 dark:text-zinc-400">
                      {selectedActivity.organization} •{" "}
                      {selectedActivity.location}
                    </p>
                    <p className="text-sm text-zinc-500 dark:text-zinc-500 mt-1">
                      📅 {selectedActivity.period}
                    </p>
                  </div>
                </div>
                <button
                  onClick={() => setSelectedActivity(null)}
                  className="text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-200 text-2xl"
                  aria-label="Close"
                >
                  ×
                </button>
              </div>
            </div>

            {/* Modal Body */}
            <div className="p-6">
              {/* Type Badge */}
              <div className="mb-4">
                <span
                  className={`inline-block px-3 py-1 rounded-full text-sm font-medium ${getTypeColor(
                    selectedActivity.type,
                  )}`}
                >
                  {getTypeLabel(selectedActivity.type)}
                </span>
              </div>

              {/* Description */}
              <p className="text-zinc-700 dark:text-zinc-300 mb-6">
                {selectedActivity.description}
              </p>

              {/* Details */}
              <div className="mb-6">
                <h4 className="text-lg font-bold text-black dark:text-white mb-3">
                  Key Highlights
                </h4>
                <ul className="space-y-2">
                  {selectedActivity.details.map((detail, index) => (
                    <li
                      key={index}
                      className="flex items-start gap-3 text-zinc-700 dark:text-zinc-300"
                    >
                      <span className="text-green-600 dark:text-green-400 mt-1">
                        ✓
                      </span>
                      <span>{detail}</span>
                    </li>
                  ))}
                </ul>
              </div>

              {/* Skills */}
              <div>
                <h4 className="text-lg font-bold text-black dark:text-white mb-3">
                  Skills & Technologies
                </h4>
                <div className="flex flex-wrap gap-2">
                  {selectedActivity.skills.map((skill, index) => (
                    <span
                      key={index}
                      className="px-3 py-2 bg-zinc-200 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 rounded-lg text-sm font-medium"
                    >
                      {skill}
                    </span>
                  ))}
                </div>
              </div>
            </div>

            {/* Modal Footer */}
            <div className="sticky bottom-0 bg-white dark:bg-zinc-900 border-t-2 border-zinc-200 dark:border-zinc-800 p-6">
              <button
                onClick={() => setSelectedActivity(null)}
                className="w-full px-6 py-3 bg-black dark:bg-white text-white dark:text-black rounded-lg font-medium transition-all hover:scale-105"
              >
                Close
              </button>
            </div>
          </div>
        </div>
      )}
    </>
  );
}
