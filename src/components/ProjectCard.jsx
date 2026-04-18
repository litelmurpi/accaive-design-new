import React, { useRef } from "react";
import { Link } from "react-router-dom";
import gsap from "gsap";
import { useGSAP } from "@gsap/react";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

const ProjectCard = ({
  title,
  slug,
  category,
  img,
  size = "small",
  className,
  index = 0,
}) => {
  const cardRef = useRef(null);
  const imageRef = useRef(null);
  const overlayRef = useRef(null);

  useGSAP(
    () => {
      gsap.from(cardRef.current, {
        y: 50,
        opacity: 0,
        duration: 0.8,
        delay: index * 0.1,
        ease: "power3.out",
        scrollTrigger: {
          trigger: cardRef.current,
          start: "top 90%",
          toggleActions: "play none none reverse",
        },
      });
    },
    { scope: cardRef },
  );

  const handleMouseEnter = () => {
    gsap.to(imageRef.current, {
      scale: 1.08,
      duration: 0.7,
      ease: "power2.out",
    });
    gsap.to(overlayRef.current, { opacity: 1, duration: 0.3 });
  };

  const handleMouseLeave = () => {
    gsap.to(imageRef.current, { scale: 1, duration: 0.7, ease: "power2.out" });
    gsap.to(overlayRef.current, { opacity: 0, duration: 0.3 });
  };

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
      ref={cardRef}
      onMouseEnter={handleMouseEnter}
      onMouseLeave={handleMouseLeave}
      className={`group relative overflow-hidden block w-full rounded-2xl transition-all duration-500 hover:shadow-2xl ${
        className || ""
      }`}
    >
      <div className={`w-full overflow-hidden bg-gray-800 ${getAspectRatio()}`}>
        <img
          ref={imageRef}
          src={img}
          alt={title}
          loading="lazy"
          className="w-full h-full object-cover transition-transform duration-700"
        />
      </div>
      <div
        ref={overlayRef}
        className="absolute inset-0 bg-linear-to-t from-black/80 via-black/20 to-transparent opacity-0 flex flex-col justify-end p-6 md:p-8 transition-opacity duration-300"
      >
        <span className="text-white/70 text-xs uppercase tracking-widest mb-2">
          {category}
        </span>
        <h3 className="text-white font-serif text-2xl md:text-3xl">{title}</h3>
      </div>
    </Link>
  );
};

export default ProjectCard;
