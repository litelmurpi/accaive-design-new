import React from "react";
import Contact from "../components/Contact";
import { usePress } from "../hooks/useSecondary";
import Skeleton from "../components/Skeleton";

const Press = () => {
  const { press: articles, loading } = usePress();

  return (
    <div className="pt-32">
      <div className="px-6 md:px-12 mb-20">
        <h1 className="font-serif text-5xl md:text-7xl lg:text-8xl leading-tight mb-8">
          Press
        </h1>
        <p className="text-xl text-gray-600 max-w-2xl">
          Latest news, awards, and features.
        </p>
      </div>

      <div className="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-16 px-6 md:px-12 mb-20">
        {loading
          ? Array(4)
              .fill(0)
              .map((_, i) => (
                <div
                  key={i}
                  className="border-t border-gray-200 pt-6 space-y-4"
                >
                  <Skeleton className="w-1/3 h-4" />
                  <Skeleton className="w-full h-10" />
                </div>
              ))
          : articles.map((article, idx) => (
              <div
                key={article.id || idx}
                className="border-t border-gray-200 pt-6 group cursor-pointer"
              >
                <div className="flex justify-between items-center mb-4 text-xs uppercase tracking-widest text-gray-400">
                  <span>{article.source}</span>
                  <span>
                    {new Date(article.published_at).toLocaleDateString(
                      "en-US",
                      { month: "short", year: "numeric", timeZone: "UTC" },
                    ) || article.date}
                  </span>
                </div>
                <h3 className="text-3xl font-serif mb-6 group-hover:text-gray-600 transition-colors leading-tight">
                  {article.title}
                </h3>
                <a
                  href={article.url || article.link || "#"}
                  className="text-sm underline decoration-gray-300 underline-offset-4 group-hover:decoration-black transition-all"
                >
                  Read Article
                </a>
              </div>
            ))}
      </div>
      <Contact />
    </div>
  );
};

export default Press;
