import React, { useRef } from "react";
import gsap from "gsap";
import { useGSAP } from "@gsap/react";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { ArrowUpRight } from "lucide-react";
import { Link } from "react-router-dom";

gsap.registerPlugin(ScrollTrigger);

const Contact = () => {
  const containerRef = useRef(null);
  const textRef = useRef(null);
  const buttonRef = useRef(null);

  useGSAP(
    () => {
      const tl = gsap.timeline({
        scrollTrigger: {
          trigger: containerRef.current,
          start: "top 80%",
          toggleActions: "play none none reverse",
        },
      });

      tl.from(textRef.current, {
        y: 100,
        opacity: 0,
        duration: 1,
        ease: "power3.out",
      }).from(
        buttonRef.current,
        {
          scale: 0,
          opacity: 0,
          duration: 0.8,
          ease: "back.out(1.7)",
        },
        "-=0.5"
      );
    },
    { scope: containerRef }
  );

  return (
    <section
      ref={containerRef}
      className="py-32 px-6 md:px-12 bg-white text-black flex flex-col items-center text-center"
    >
      <div ref={textRef} className="max-w-4xl mb-12">
        <h2 className="font-serif text-5xl md:text-7xl lg:text-8xl leading-tight mb-6">
          Have an idea? <br />
          <span className="italic text-gray-400">Let's build it.</span>
        </h2>
        <p className="text-xl md:text-2xl text-gray-600 font-light max-w-2xl mx-auto">
          We collaborate with ambitious brands and people. Let's make something
          great together.
        </p>
      </div>

      <Link
        ref={buttonRef}
        to="/contact"
        className="group relative px-8 py-4 bg-black text-white rounded-full overflow-hidden flex items-center gap-3 text-lg font-medium hover:bg-gray-900 transition-colors"
      >
        <span className="relative z-10">Start a Project</span>
        <ArrowUpRight className="relative z-10 group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform" />
      </Link>
    </section>
  );
};

export default Contact;
