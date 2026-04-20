/* eslint-disable react-hooks/refs */
import React, { useRef } from "react";
import gsap from "gsap";
import { useGSAP } from "@gsap/react";

const TeamMember = ({ name, role, img }) => {
  const containerRef = useRef(null);
  const imageRef = useRef(null);

  const { contextSafe } = useGSAP({ scope: containerRef });

  const handleMouseEnter = contextSafe(() => {
    gsap.to(containerRef.current, {
      y: -10,
      duration: 0.4,
      ease: "power2.out",
    });
    gsap.to(imageRef.current, {
      scale: 1.1,
      grayscale: 0,
      duration: 0.5,
      ease: "power2.out",
    });
  });

  const handleMouseLeave = contextSafe(() => {
    gsap.to(containerRef.current, { y: 0, duration: 0.4, ease: "power2.out" });
    gsap.to(imageRef.current, {
      scale: 1,
      grayscale: 1,
      duration: 0.5,
      ease: "power2.out",
    });
  });

  return (
    <div
      ref={containerRef}
      onMouseEnter={handleMouseEnter}
      onMouseLeave={handleMouseLeave}
      className="flex flex-col cursor-pointer"
    >
      <div className="w-full aspect-3/4 overflow-hidden mb-4 bg-gray-800">
        <img
          ref={imageRef}
          src={img}
          alt={name}
          className="w-full h-full object-cover grayscale"
        />
      </div>
      <h4 className="font-bold text-lg text-gray-900">{name}</h4>
      <p className="text-sm text-gray-500">{role}</p>
    </div>
  );
};

export default TeamMember;
