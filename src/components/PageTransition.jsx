import React, { useRef } from "react";
import gsap from "gsap";
import { useGSAP } from "@gsap/react";
import { useLocation } from "react-router-dom";

const PageTransition = ({ children }) => {
  const containerRef = useRef(null);
  const location = useLocation();

  useGSAP(
    () => {
      gsap.fromTo(
        containerRef.current,
        { opacity: 0, y: 15 },
        {
          opacity: 1,
          y: 0,
          duration: 0.8,
          ease: "power3.out",
          clearProps: "all",
        },
      );
    },
    { dependencies: [location.pathname], scope: containerRef },
  );

  return (
    <div ref={containerRef} className="w-full">
      {children}
    </div>
  );
};

export default PageTransition;
