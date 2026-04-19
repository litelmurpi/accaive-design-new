import React from "react";

const Skeleton = ({ className = "", type = "rect" }) => {
  // A simple shimmering placeholder component
  const baseClass = "bg-gray-200 dark:bg-[#1a1a1a] overflow-hidden relative";
  const shimmerClass =
    "after:absolute after:inset-0 after:-translate-x-full after:animate-[shimmer_2s_infinite] after:bg-gradient-to-r after:from-transparent after:via-white/20 after:to-transparent dark:after:via-white/5";

  const roundedClass = type === "circle" ? "rounded-full" : "rounded-lg";

  return (
    <div
      className={`${baseClass} ${shimmerClass} ${roundedClass} ${className}`}
    />
  );
};

export default Skeleton;
