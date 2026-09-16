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
  const [hasError, setHasError] = React.useState(false);

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
      <div className={`w-full overflow-hidden bg-neutral-900 ${getAspectRatio()} relative`}>
        {img && !hasError ? (
          <img
            src={img}
            alt={title}
            loading="lazy"
            decoding="async"
            onError={() => setHasError(true)}
            className="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-105 will-change-transform"
          />
        ) : (
          <div className="w-full h-full flex flex-col items-center justify-center bg-linear-to-br from-neutral-800 via-neutral-900 to-neutral-950 p-6 text-center relative overflow-hidden transition-transform duration-700 ease-out group-hover:scale-105">
            <div className="absolute inset-0 bg-[radial-gradient(#ffffff0a_1px,transparent_1px)] [background-size:16px_16px] opacity-40 pointer-events-none" />
            <div className="w-12 h-12 rounded-full border border-white/10 flex items-center justify-center mb-3 text-white/30 group-hover:border-white/20 transition-colors">
              <svg className="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.2} d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
              </svg>
            </div>
            <span className="text-white/40 text-xs tracking-widest uppercase font-mono">{category || "Architecture"}</span>
          </div>
        )}
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

