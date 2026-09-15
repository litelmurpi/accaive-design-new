import React, { useRef } from "react";
import gsap from "gsap";
import { useGSAP } from "@gsap/react";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import videoClip from "../assets/Clip1.mp4";
import { useSettings } from "../hooks/useSecondary";

gsap.registerPlugin(ScrollTrigger);

const Hero = () => {
  const containerRef = useRef(null);
  const headingRef = useRef(null);
  const videoContainerRef = useRef(null);
  const { settings } = useSettings();

  useGSAP(
    () => {
      const tl = gsap.timeline();

      // Entrance Animation
      tl.from(headingRef.current, {
        y: 50,
        opacity: 0,
        duration: 1,
        ease: "power3.out",
      }).from(
        videoContainerRef.current,
        {
          opacity: 0,
          duration: 1,
          ease: "power3.out",
        },
        "-=0.5",
      );

      // Scroll Animation for Video
      gsap.to(videoContainerRef.current, {
        scale: 1.15,
        scrollTrigger: {
          trigger: containerRef.current,
          start: "top top",
          end: "bottom top",
          scrub: true,
        },
      });
    },
    { scope: containerRef },
  );

  let heroHeadline = settings?.hero_headline;
  if (settings?.hero_title_prefix || settings?.hero_title_accent || settings?.hero_title_suffix) {
    const prefix = settings?.hero_title_prefix || "a creation that";
    const accent = settings?.hero_title_accent || "craves";
    const suffix = settings?.hero_title_suffix || "creative design.";
    heroHeadline = `${prefix} <br /> <span class='italic'>${accent}</span> <br /> <span class='italic'>${suffix}</span>`;
  }
  if (!heroHeadline) {
    heroHeadline = "a creation that <br /> <span class='italic'>craves</span> <br /> <span class='italic'>creative</span> design.";
  }

  const videoSrc = settings?.hero_video_url || videoClip;
  const posterSrc = settings?.hero_video_poster || "/hero-poster.webp";

  return (
    <section
      ref={containerRef}
      className="min-h-screen flex flex-col justify-center items-center text-center px-4 pt-44 pb-12 transition-colors duration-500"
    >
      <h1
        ref={headingRef}
        className="font-serif text-4xl md:text-6xl lg:text-7xl leading-tight mb-24 max-w-4xl opacity-100"
        dangerouslySetInnerHTML={{ __html: heroHeadline }}
      />

      <div
        ref={videoContainerRef}
        className="mt-20 mb-40 w-full max-w-6xl aspect-video md:aspect-[2.35/1] overflow-hidden rounded-lg shadow-2xl relative opacity-100 will-change-transform"
      >
        <video
          key={videoSrc}
          autoPlay
          muted
          loop
          playsInline
          preload="metadata"
          poster={posterSrc}
          className="w-full h-full object-cover"
        >
          <source src={videoSrc} type="video/mp4" />
          {/* Fallback image */}
          <img
            fetchPriority="high"
            src={posterSrc}
            className="w-full h-full object-cover"
            alt="Accaive Architecture"
          />
        </video>
        <div className="absolute inset-0 bg-black/10"></div>
      </div>
    </section>
  );
};

export default Hero;
