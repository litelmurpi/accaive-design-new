import React, { useRef } from "react";
import { Link } from "react-router-dom";
import gsap from "gsap";
import { useGSAP } from "@gsap/react";

const NotFound = () => {
  const containerRef = useRef(null);
  const contentRef = useRef(null);

  useGSAP(
    () => {
      gsap.from(contentRef.current, {
        y: 50,
        opacity: 0,
        duration: 1,
        ease: "power3.out",
        delay: 0.2,
      });
    },
    { scope: containerRef },
  );

  return (
    <section
      ref={containerRef}
      className="min-h-screen flex items-center justify-center pt-24 pb-12 px-6 bg-[#f8f8f8] dark:bg-[#0a0a0a]"
    >
      <div ref={contentRef} className="text-center">
        <div className="text-[150px] md:text-[250px] font-serif leading-none tracking-tighter mb-4 text-[#1a1a1a] dark:text-[#f8f8f8]">
          404
        </div>
        <h1 className="text-2xl md:text-3xl font-medium tracking-wide mb-8">
          Page Not Found
        </h1>
        <p className="max-w-md mx-auto text-gray-500 mb-12">
          The architecture you're looking for doesn't exist. It might have been
          demolished, moved, or never built at all.
        </p>
        <Link
          to="/"
          className="inline-block px-8 py-3 bg-[#1a1a1a] text-white dark:bg-white dark:text-[#1a1a1a] rounded-full hover:scale-105 transition-transform duration-300 font-medium cursor-pointer"
        >
          Return Home
        </Link>
      </div>
    </section>
  );
};

export default NotFound;
