/* eslint-disable react-hooks/refs */
import React, { useRef } from "react";
import gsap from "gsap";
import { useGSAP } from "@gsap/react";

const TeamMember = ({ name, role, img }) => {
  const containerRef = useRef(null);
  const imageRef = useRef(null);
  const [hasError, setHasError] = React.useState(false);

  const initials = name
    ? name
        .split(" ")
        .filter(Boolean)
        .map((n) => n[0])
        .slice(0, 2)
        .join("")
        .toUpperCase()
    : "AD";

  const { contextSafe } = useGSAP({ scope: containerRef });

  const handleMouseEnter = contextSafe(() => {
    gsap.to(containerRef.current, {
      y: -10,
      duration: 0.4,
      ease: "power2.out",
    });
    if (imageRef.current) {
      gsap.to(imageRef.current, {
        scale: 1.06,
        grayscale: 0,
        duration: 0.5,
        ease: "power2.out",
      });
    }
  });

  const handleMouseLeave = contextSafe(() => {
    gsap.to(containerRef.current, { y: 0, duration: 0.4, ease: "power2.out" });
    if (imageRef.current) {
      gsap.to(imageRef.current, {
        scale: 1,
        grayscale: 1,
        duration: 0.5,
        ease: "power2.out",
      });
    }
  });

  return (
    <div
      ref={containerRef}
      onMouseEnter={handleMouseEnter}
      onMouseLeave={handleMouseLeave}
      className="flex flex-col cursor-pointer"
    >
      <div className="w-full aspect-3/4 overflow-hidden mb-4 bg-neutral-900 relative rounded-lg">
        {img && !hasError ? (
          <img
            ref={imageRef}
            src={img}
            alt={name}
            onError={() => setHasError(true)}
            className="w-full h-full object-cover grayscale"
          />
        ) : (
          <div
            ref={imageRef}
            className="w-full h-full flex flex-col items-center justify-center bg-linear-to-b from-neutral-800 to-neutral-900 border border-white/5 relative overflow-hidden transition-colors duration-500"
          >
            <div className="absolute inset-0 bg-[radial-gradient(#ffffff0a_1px,transparent_1px)] [background-size:12px_12px] opacity-40 pointer-events-none" />
            <span className="font-serif text-3xl md:text-4xl text-white/40 tracking-widest font-light select-none">
              {initials}
            </span>
            <span className="text-[10px] tracking-[0.25em] text-white/30 uppercase mt-2 font-mono select-none">
              Accaive Studio
            </span>
          </div>
        )}
      </div>
      <h4 className="font-bold text-lg">{name}</h4>
      <p className="text-sm opacity-60">{role}</p>
    </div>
  );
};

export default TeamMember;
