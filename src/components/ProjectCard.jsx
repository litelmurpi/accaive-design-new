import React from "react";
import { Link } from "react-router-dom";

const ProjectCard = ({
  title,
  slug,
  category,
  img,
  size = "small",
  className,
}) => {
  // Structured aspect ratios based on size prop
  const getAspectRatio = () => {
    if (size === "large") return "aspect-4/5";
    if (size === "tall") return "aspect-3/5";
    if (size === "wide") return "aspect-video";
    return "aspect-square"; // small/default
  };

  return (
    <Link
      to={slug ? `/project/${slug}` : "#"}
      className={`project-card group relative overflow-hidden block w-full rounded-2xl transition-shadow duration-500 hover:shadow-2xl ${
        className || ""
      }`}
    >
      <div className={`w-full overflow-hidden bg-gray-900 ${getAspectRatio()}`}>
        <img
          src={img}
          alt={title}
          loading="lazy"
          decoding="async"
          className="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-105 will-change-transform"
        />
      </div>
      <div
        className="absolute inset-0 bg-linear-to-t from-black/85 via-black/30 to-transparent opacity-0 group-hover:opacity-100 flex flex-col justify-end p-6 md:p-8 transition-opacity duration-300 pointer-events-none"
      >
        <span className="text-white/70 text-xs uppercase tracking-widest mb-2 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
          {category}
        </span>
        <h3 className="text-white font-serif text-2xl md:text-3xl transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300 delay-75">
          {title}
        </h3>
      </div>
    </Link>
  );
};

export default ProjectCard;

