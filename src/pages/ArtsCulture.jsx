import React from "react";
import Contact from "../components/Contact";
import { useExhibitions } from "../hooks/useSecondary";
import Skeleton from "../components/Skeleton";

const ArtsCulture = () => {
  const { exhibitions, loading } = useExhibitions();

  return (
    <div className="pt-32">
      <div className="px-6 md:px-12 mb-20">
        <h1 className="font-serif text-5xl md:text-7xl lg:text-8xl leading-tight mb-8">
          Arts & Culture
        </h1>
        <p className="text-xl text-gray-600 max-w-2xl">
          Exploring the intersection of design, heritage, and modern artistic
          expression.
        </p>
      </div>

      <div className="px-6 md:px-12 mb-20 space-y-24">
        {loading
          ? Array(3)
              .fill(0)
              .map((_, i) => (
                <div
                  key={i}
                  className="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center"
                >
                  <Skeleton className="w-full aspect-video rounded-lg" />
                  <div className="space-y-4">
                    <Skeleton className="w-1/4 h-4" />
                    <Skeleton className="w-2/3 h-10" />
                    <Skeleton className="w-full h-24" />
                  </div>
                </div>
              ))
          : exhibitions.map((exhibit, idx) => (
              <div
                key={exhibit.id || idx}
                className="group grid grid-cols-1 lg:grid-cols-2 gap-12 items-center"
              >
                <div
                  className={`overflow-hidden rounded-lg ${idx % 2 === 1 ? "lg:order-2" : ""}`}
                >
                  <img
                    src={exhibit.img || exhibit.image}
                    alt={exhibit.title}
                    className="w-full aspect-video object-cover transition-transform duration-700 group-hover:scale-105"
                  />
                </div>
                <div className={idx % 2 === 1 ? "lg:order-1" : ""}>
                  <div className="flex items-center gap-4 mb-4 text-sm uppercase tracking-widest text-gray-400">
                    <span>{exhibit.location}</span>
                    <span className="w-px h-4 bg-gray-300"></span>
                    <span>{exhibit.year}</span>
                  </div>
                  <h2 className="font-serif text-4xl md:text-5xl mb-6">
                    {exhibit.title}
                  </h2>
                  <p className="text-gray-600 text-lg leading-relaxed mb-8">
                    {exhibit.description ||
                      "An immersive experience designed to challenge perceptions of space and time."}
                  </p>
                  <button className="text-black border-b border-black pb-1 hover:opacity-60 transition-opacity">
                    View Exhibition
                  </button>
                </div>
              </div>
            ))}
      </div>

      <Contact />
    </div>
  );
};

export default ArtsCulture;
