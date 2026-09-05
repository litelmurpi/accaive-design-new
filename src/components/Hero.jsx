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
  const awardsRef = useRef(null);
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
      })
        .from(
          awardsRef.current,
          {
            opacity: 0,
            duration: 1,
            ease: "power3.out",
          },
          "-=0.5",
        )
        .from(
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

  const heroHeadline = settings?.hero_headline || "a creation that <br /> <span class='italic'>craves</span> <br /> <span class='italic'>creative</span> design.";
  const heroAwardSubtitle = settings?.hero_award_subtitle || "7x Agency of the Year";
  const heroAwards = settings?.hero_awards
    ? settings.hero_awards.split(",").map((item) => item.trim()).filter(Boolean)
    : ["( ArchDaily 2024 )", "( Pritzker Mention 2023 )", "( Dezeen Awards 2024 )", "( AIA Firm of Year 2025 )"];
  const videoSrc = settings?.hero_video_url || videoClip;
  const posterSrc = settings?.hero_video_poster || "https://images.unsplash.com/photo-1486325212027-8081e485255e?q=80&w=2070&auto=format&fit=crop";

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
        ref={awardsRef}
        className="flex flex-col items-center gap-6 mb-20 opacity-100"
      >
        <span className="text-[10px] uppercase tracking-widest text-gray-400">
          {heroAwardSubtitle}
        </span>
        <div className="flex flex-wrap justify-center gap-x-6 gap-y-3 text-[10px] md:text-xs font-medium text-gray-500 tracking-wide font-sans">
          {heroAwards.map((award, index) => (
            <span key={index}>{award}</span>
          ))}
        </div>
      </div>

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
            loading="lazy"
            src={posterSrc}
            className="w-full h-full object-cover"
            alt="Architecture"
          />
        </video>
        <div className="absolute inset-0 bg-black/10"></div>
      </div>
    </section>
  );
};

export default Hero;
