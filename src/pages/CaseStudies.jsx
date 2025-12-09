import React, { useState, useRef } from "react";
import { useGSAP } from "@gsap/react";
import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { LayoutGrid, List } from "lucide-react";
import Contact from "../components/Contact";

gsap.registerPlugin(ScrollTrigger);

const caseStudies = [
  {
    id: 1,
    title: "The Awakening",
    brand: "BOSE",
    category: "Brand Strategy",
    img: "https://images.unsplash.com/photo-1558618666-fcd25c85cd64?q=80&w=800&auto=format&fit=crop",
    bgColor: "bg-[#1a1a1a]",
    height: "h-[520px]",
  },
  {
    id: 2,
    title: "The Making of a New American Capitalist",
    brand: "Robinhood",
    category: "Brand Identity",
    img: "https://images.unsplash.com/photo-1611974789855-9c2a0a7236a3?q=80&w=800&auto=format&fit=crop",
    bgColor: "bg-[#00c805]",
    height: "h-[280px]",
  },
  {
    id: 3,
    title: "A Tale of Two Citizens",
    brand: "ARCANE",
    category: "Campaign",
    img: "https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=800&auto=format&fit=crop",
    bgColor: "bg-[#937860]",
    height: "h-[450px]",
  },
  {
    id: 4,
    title: "Symphony of Innovation",
    brand: "SYMPHONY",
    category: "Brand Refresh",
    img: "https://images.unsplash.com/photo-1507838153414-b4b713384a76?q=80&w=800&auto=format&fit=crop",
    bgColor: "bg-[#2a2a2a]",
    height: "h-[320px]",
  },
  {
    id: 5,
    title: "Future Forward",
    brand: "VELOCITY",
    category: "Reposition",
    img: "https://images.unsplash.com/photo-1451187580459-43490279c0fa?q=80&w=800&auto=format&fit=crop",
    bgColor: "bg-[#ff6b35]",
    height: "h-[580px]",
  },
  {
    id: 6,
    title: "The Art of Motion",
    brand: "PRIMARY",
    category: "Brand Creation",
    img: "https://images.unsplash.com/photo-1503203294957-42b9c56b5e04?q=80&w=800&auto=format&fit=crop",
    bgColor: "bg-[#e63946]",
    height: "h-[380px]",
  },
];

// Shelf View Card Component - Abstract Aesthetic Design
const ShelfCard = ({ study, index }) => {
  const cardRef = useRef(null);
  const [isHovered, setIsHovered] = useState(false);

  useGSAP(() => {
    gsap.from(cardRef.current, {
      y: 60,
      opacity: 0,
      duration: 0.8,
      delay: index * 0.1,
      ease: "power3.out",
      scrollTrigger: {
        trigger: cardRef.current,
        start: "top 90%",
      },
    });
  }, []);

  // Generate random geometric pattern based on index
  const patterns = [
    { clipPath: "polygon(0 0, 100% 0, 100% 70%, 0 100%)" },
    { clipPath: "polygon(0 30%, 100% 0, 100% 100%, 0 100%)" },
    { clipPath: "polygon(50% 0, 100% 50%, 50% 100%, 0 50%)" },
    { clipPath: "polygon(0 0, 80% 0, 100% 100%, 0 100%)" },
    { clipPath: "polygon(20% 0, 100% 0, 100% 100%, 0 100%)" },
    { clipPath: "polygon(0 0, 100% 20%, 100% 80%, 0 100%)" },
  ];
  const pattern = patterns[index % patterns.length];

  // Varied margins for abstract effect - more dramatic
  const abstractMargins = [
    "mt-0",
    "md:mt-32",
    "md:-mt-12",
    "md:mt-48",
    "md:mt-16",
    "md:mt-40",
  ];
  const abstractMargin = abstractMargins[index % abstractMargins.length];

  // Subtle rotations for abstract feel
  const rotations = [
    "rotate-0",
    "md:rotate-1",
    "md:-rotate-1",
    "md:rotate-2",
    "md:-rotate-2",
    "rotate-0",
  ];
  const rotation = rotations[index % rotations.length];

  // Varied widths for more chaos
  const widths = [
    "w-full",
    "md:w-[95%]",
    "md:w-[90%]",
    "w-full",
    "md:w-[85%]",
    "md:w-[92%]",
  ];
  const width = widths[index % widths.length];

  return (
    <div
      ref={cardRef}
      className={`group cursor-pointer overflow-hidden rounded-2xl ${study.height} ${width} transition-all duration-700 relative break-inside-avoid mb-8 ${abstractMargin} ${rotation} hover:rotate-0 hover:scale-[1.02]`}
      onMouseEnter={() => setIsHovered(true)}
      onMouseLeave={() => setIsHovered(false)}
    >
      {/* Animated border glow effect */}
      <div
        className="absolute -inset-[2px] rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500 z-0"
        style={{
          background:
            "linear-gradient(135deg, #ff6b6b, #4ecdc4, #45b7d1, #96ceb4, #ffeaa7, #dfe6e9, #ff6b6b)",
          backgroundSize: "400% 400%",
          animation: isHovered ? "gradientShift 3s ease infinite" : "none",
        }}
      />

      {/* Main card container */}
      <div className="relative w-full h-full overflow-hidden rounded-2xl bg-[#0f0f0f] z-10">
        {/* Abstract geometric shape overlay */}
        <div
          className="absolute inset-0 z-20 transition-all duration-700 group-hover:scale-110"
          style={{
            ...pattern,
            background:
              "linear-gradient(135deg, rgba(255,255,255,0.03) 0%, rgba(255,255,255,0.08) 100%)",
          }}
        />

        {/* Background image with advanced effects */}
        <div className="absolute inset-0 transition-all duration-700 group-hover:scale-110">
          <img
            src={study.img}
            alt={study.brand}
            className="w-full h-full object-cover transition-all duration-700 filter group-hover:brightness-75 group-hover:saturate-150"
          />
        </div>

        {/* Abstract gradient mesh overlay */}
        <div
          className="absolute inset-0 z-30 opacity-60 group-hover:opacity-80 transition-opacity duration-500"
          style={{
            background: `
                            radial-gradient(ellipse at 20% 80%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
                            radial-gradient(ellipse at 80% 20%, rgba(255, 119, 115, 0.2) 0%, transparent 50%),
                            radial-gradient(ellipse at 50% 50%, rgba(0, 0, 0, 0.4) 0%, transparent 70%)
                        `,
          }}
        />

        {/* Diagonal abstract line */}
        <div
          className="absolute z-30 bg-white/10 group-hover:bg-white/20 transition-all duration-500 group-hover:translate-x-2 group-hover:-translate-y-2"
          style={{
            width: "150%",
            height: "1px",
            top: "40%",
            left: "-25%",
            transform: "rotate(-35deg)",
          }}
        />

        {/* Floating geometric accent */}
        <div
          className="absolute top-4 right-4 w-12 h-12 z-40 opacity-0 group-hover:opacity-100 transition-all duration-500 group-hover:rotate-45"
          style={{
            border: "1px solid rgba(255,255,255,0.3)",
            borderRadius: "4px",
          }}
        />

        {/* Circle accent */}
        <div
          className="absolute bottom-20 right-8 w-24 h-24 rounded-full z-30 opacity-0 group-hover:opacity-100 transition-all duration-700 group-hover:scale-110"
          style={{
            border: "1px solid rgba(255,255,255,0.15)",
          }}
        />

        {/* Content overlay - slides up on hover */}
        <div className="absolute bottom-0 left-0 right-0 z-40 p-6 transform translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-500 ease-out">
          <div className="flex items-center gap-2 mb-2">
            <span className="w-8 h-[1px] bg-white/50" />
            <p className="text-white/60 text-xs uppercase tracking-[0.2em]">
              {study.category}
            </p>
          </div>
          <h3 className="text-white text-lg font-light tracking-wide">
            {study.title}
          </h3>
        </div>

        {/* Brand name - abstract positioning */}
        <div
          className="absolute z-40 transition-all duration-700 group-hover:tracking-[0.3em]"
          style={{
            bottom: index % 2 === 0 ? "50%" : "45%",
            left: "50%",
            transform: "translate(-50%, 50%)",
          }}
        >
          <span
            className="text-white text-5xl font-bold tracking-[0.15em] opacity-90 group-hover:opacity-100 transition-all duration-500"
            style={{
              textShadow: "0 4px 30px rgba(0,0,0,0.5)",
              fontFamily: "serif",
            }}
          >
            {study.brand}
          </span>
        </div>

        {/* Bottom gradient fade */}
        <div
          className="absolute bottom-0 left-0 right-0 h-32 z-35 pointer-events-none"
          style={{
            background:
              "linear-gradient(to top, rgba(0,0,0,0.8) 0%, transparent 100%)",
          }}
        />
      </div>
    </div>
  );
};

// Spines View Card Component - Abstract Aesthetic Design
const SpineCard = ({ study, index }) => {
  const cardRef = useRef(null);
  const [isHovered, setIsHovered] = useState(false);

  useGSAP(() => {
    gsap.from(cardRef.current, {
      x: -40,
      opacity: 0,
      duration: 0.6,
      delay: index * 0.08,
      ease: "power2.out",
      scrollTrigger: {
        trigger: cardRef.current,
        start: "top 90%",
      },
    });
  }, []);

  // Unique accent colors for each card
  const accentColors = [
    "rgba(255, 107, 107, 0.6)",
    "rgba(78, 205, 196, 0.6)",
    "rgba(69, 183, 209, 0.6)",
    "rgba(150, 206, 180, 0.6)",
    "rgba(255, 234, 167, 0.6)",
    "rgba(108, 92, 231, 0.6)",
  ];
  const accentColor = accentColors[index % accentColors.length];

  return (
    <div
      ref={cardRef}
      className="group cursor-pointer rounded-xl overflow-hidden transition-all duration-500 relative"
      onMouseEnter={() => setIsHovered(true)}
      onMouseLeave={() => setIsHovered(false)}
    >
      {/* Animated gradient border */}
      <div
        className="absolute -inset-[1px] rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-500 z-0"
        style={{
          background: `linear-gradient(90deg, transparent, ${accentColor}, transparent)`,
          backgroundSize: "200% 100%",
          animation: isHovered ? "shimmer 2s ease infinite" : "none",
        }}
      />

      {/* Main card container */}
      <div
        className={`relative ${study.bgColor} z-10 rounded-xl overflow-hidden`}
      >
        {/* Background image - reveals on hover */}
        <div
          className="absolute inset-0 opacity-0 group-hover:opacity-30 transition-opacity duration-700"
          style={{
            backgroundImage: `url(${study.img})`,
            backgroundSize: "cover",
            backgroundPosition: "center",
            filter: "blur(2px)",
          }}
        />

        {/* Abstract geometric overlay */}
        <div
          className="absolute inset-0 opacity-20 group-hover:opacity-40 transition-opacity duration-500"
          style={{
            background: `
                            radial-gradient(circle at 0% 50%, ${accentColor} 0%, transparent 30%),
                            radial-gradient(circle at 100% 50%, rgba(255,255,255,0.1) 0%, transparent 30%)
                        `,
          }}
        />

        {/* Diagonal abstract lines */}
        <div className="absolute inset-0 overflow-hidden opacity-20 group-hover:opacity-40 transition-opacity duration-500">
          <div
            className="absolute w-[200%] h-px bg-white/30 group-hover:translate-x-10 transition-transform duration-700"
            style={{ top: "30%", left: "-50%", transform: "rotate(-5deg)" }}
          />
          <div
            className="absolute w-[200%] h-px bg-white/20 group-hover:-translate-x-10 transition-transform duration-700"
            style={{ top: "70%", left: "-50%", transform: "rotate(-5deg)" }}
          />
        </div>

        {/* Content */}
        <div className="relative flex items-center justify-between h-[160px] px-10 z-20">
          {/* Left Side - Abstract number + Text */}
          <div className="flex-1 flex items-center gap-8">
            {/* Abstract index number */}
            <div
              className="text-8xl font-bold opacity-10 group-hover:opacity-20 transition-all duration-500 group-hover:scale-110"
              style={{ fontFamily: "serif" }}
            >
              {String(index + 1).padStart(2, "0")}
            </div>

            {/* Text content */}
            <div className="relative">
              <div className="flex items-center gap-3 mb-2">
                <span
                  className="w-0 group-hover:w-8 h-px transition-all duration-500"
                  style={{ backgroundColor: accentColor }}
                />
                <p className="text-white/50 text-xs uppercase tracking-[0.2em] group-hover:text-white/70 transition-colors duration-300">
                  {study.category}
                </p>
              </div>
              <p className="text-white/80 text-sm group-hover:text-white transition-colors duration-300 max-w-xs">
                {study.title}
              </p>
            </div>
          </div>

          {/* Right Side - Brand/Logo with abstract styling */}
          <div className="flex-1 flex justify-end items-center gap-4">
            {/* Geometric accent */}
            <div
              className="w-8 h-8 rounded-full opacity-0 group-hover:opacity-100 transition-all duration-500 group-hover:rotate-90"
              style={{
                border: `1px solid ${accentColor}`,
              }}
            />

            {/* Brand name */}
            <span
              className="text-white text-4xl md:text-5xl font-bold tracking-[0.1em] italic group-hover:tracking-[0.2em] transition-all duration-500"
              style={{
                textShadow: isHovered ? `0 0 40px ${accentColor}` : "none",
              }}
            >
              {study.brand}
            </span>

            {/* Arrow indicator */}
            <div className="ml-4 opacity-0 group-hover:opacity-100 transform translate-x-4 group-hover:translate-x-0 transition-all duration-500">
              <svg
                className="w-6 h-6 text-white/70"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  strokeLinecap="round"
                  strokeLinejoin="round"
                  strokeWidth={1.5}
                  d="M17 8l4 4m0 0l-4 4m4-4H3"
                />
              </svg>
            </div>
          </div>
        </div>

        {/* Bottom accent line */}
        <div
          className="absolute bottom-0 left-0 h-[2px] w-0 group-hover:w-full transition-all duration-700 ease-out"
          style={{ backgroundColor: accentColor }}
        />
      </div>
    </div>
  );
};

const CaseStudies = () => {
  const [viewMode, setViewMode] = useState("shelf"); // 'shelf' or 'spines'
  const containerRef = useRef(null);
  const headingRef = useRef(null);

  useGSAP(
    () => {
      gsap.from(headingRef.current, {
        y: 40,
        opacity: 0,
        duration: 1,
        ease: "power3.out",
      });
    },
    { scope: containerRef }
  );

  return (
    <div ref={containerRef} className="bg-[#0a0a0a] text-white min-h-screen">
      {/* Hero Section */}
      <div className="pt-40 pb-16 px-6 md:px-12 lg:px-20 max-w-7xl mx-auto">
        {/* View Toggle */}
        <div className="flex justify-center mb-16">
          <div className="inline-flex items-center bg-[#1a1a1a] rounded-full p-1">
            <button
              onClick={() => setViewMode("shelf")}
              className={`flex items-center gap-2 px-5 py-2.5 rounded-full text-sm font-medium transition-all duration-300 ${
                viewMode === "shelf"
                  ? "bg-white text-black"
                  : "text-white/70 hover:text-white"
              }`}
            >
              <LayoutGrid size={16} />
              Shelf
            </button>
            <button
              onClick={() => setViewMode("spines")}
              className={`flex items-center gap-2 px-5 py-2.5 rounded-full text-sm font-medium transition-all duration-300 ${
                viewMode === "spines"
                  ? "bg-white text-black"
                  : "text-white/70 hover:text-white"
              }`}
            >
              <List size={16} />
              Spines
            </button>
          </div>
        </div>

        {/* Header */}
        <div ref={headingRef} className="mb-20">
          <p className="text-white/50 text-sm font-medium tracking-widest uppercase mb-6">
            Case Studies
          </p>
          <h1 className="font-serif text-4xl md:text-5xl lg:text-6xl leading-[1.15] max-w-3xl">
            We will make your business so irresistible, its success is
            inevitable.
          </h1>
        </div>
      </div>

      {/* Case Studies Grid */}
      <div className="px-6 md:px-12 lg:px-20 pb-32">
        {viewMode === "shelf" ? (
          // Shelf View - Pinterest Masonry Layout
          <div className="columns-1 sm:columns-2 lg:columns-3 xl:columns-4 gap-6">
            {caseStudies.map((study, idx) => (
              <ShelfCard key={study.id} study={study} index={idx} />
            ))}
          </div>
        ) : (
          // Spines View - Horizontal cards
          <div className="max-w-5xl mx-auto flex flex-col gap-4">
            {caseStudies.map((study, idx) => (
              <SpineCard key={study.id} study={study} index={idx} />
            ))}
          </div>
        )}
      </div>

      <Contact />
    </div>
  );
};

export default CaseStudies;
