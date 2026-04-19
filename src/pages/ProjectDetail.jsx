import React, { useRef } from "react";
import { useParams, Link } from "react-router-dom";
import gsap from "gsap";
import { useGSAP } from "@gsap/react";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { ArrowLeft } from "lucide-react";
import { useProject } from "../hooks/useProjects";
import Skeleton from "../components/Skeleton";

gsap.registerPlugin(ScrollTrigger);

const ProjectDetail = () => {
  const { slug } = useParams();
  const { project: data, loading } = useProject(slug);
  const containerRef = useRef(null);
  const heroRef = useRef(null);
  const textRef = useRef(null);
  const galleryRef = useRef(null);

  useGSAP(
    () => {
      // Hero Image Parallax
      gsap.to(heroRef.current, {
        yPercent: 20,
        ease: "none",
        scrollTrigger: {
          trigger: containerRef.current,
          start: "top top",
          end: "bottom top",
          scrub: true,
        },
      });

      // Text Entrance
      gsap.from(textRef.current, {
        y: 50,
        opacity: 0,
        duration: 1,
        ease: "power3.out",
        scrollTrigger: {
          trigger: textRef.current,
          start: "top 80%",
        },
      });

      // Gallery Items Entrance
      const images = gsap.utils.toArray(".gallery-img");
      images.forEach((img) => {
        gsap.from(img, {
          y: 50,
          opacity: 0,
          duration: 1,
          ease: "power3.out",
          scrollTrigger: {
            trigger: img,
            start: "top 85%",
          },
        });
      });
    },
    { scope: containerRef },
  );

  if (loading) {
    return (
      <div className="bg-[#f8f8f8] dark:bg-[#0a0a0a] min-h-screen">
        <Skeleton className="w-full h-[60vh] md:h-[80vh]" />
        <div className="max-w-7xl mx-auto px-6 md:px-12 py-20">
          <div className="grid grid-cols-1 md:grid-cols-12 gap-12 mb-24">
            <div className="col-span-1 md:col-span-4 space-y-4">
              <Skeleton className="w-1/4 h-4" />
              <Skeleton className="w-3/4 h-12" />
            </div>
          </div>
        </div>
      </div>
    );
  }

  if (!data)
    return (
      <div className="min-h-screen flex items-center justify-center font-serif text-3xl">
        Project not found.
      </div>
    );

  return (
    <div
      ref={containerRef}
      className="bg-[#f8f8f8] dark:bg-[#0a0a0a] min-h-screen"
    >
      {/* Hero Section */}
      <div className="relative w-full h-[60vh] md:h-[80vh] overflow-hidden">
        <img
          ref={heroRef}
          src={data.hero_image}
          alt={data.title}
          className="absolute w-full h-[120%] object-cover top-[-10%]"
        />
        <div className="absolute inset-0 bg-black/30"></div>

        {/* Back Button */}
        <Link
          to="/case-studies"
          className="absolute top-32 left-6 md:left-12 z-10 inline-flex items-center gap-2 text-white hover:text-white/70 transition-colors bg-black/20 px-4 py-2 rounded-full backdrop-blur-md"
        >
          <ArrowLeft size={16} /> Back to Projects
        </Link>
      </div>

      {/* Content Section */}
      <div className="max-w-7xl mx-auto px-6 md:px-12 py-20">
        <div
          ref={textRef}
          className="grid grid-cols-1 md:grid-cols-12 gap-12 mb-24"
        >
          {/* Left Column: Title & Metadata */}
          <div className="col-span-1 md:col-span-4">
            <div className="text-xs uppercase tracking-widest text-gray-500 mb-4">
              {data.category}
            </div>
            <h1 className="font-serif text-5xl md:text-6xl mb-8 leading-tight">
              {data.title}
            </h1>

            <div className="space-y-6 pt-8 border-t border-gray-200 dark:border-gray-800">
              <div>
                <span className="block text-xs uppercase tracking-widest text-gray-500 mb-1">
                  Client
                </span>
                <span className="font-medium text-lg">{data.client}</span>
              </div>
              <div>
                <span className="block text-xs uppercase tracking-widest text-gray-500 mb-1">
                  Year
                </span>
                <span className="font-medium text-lg">{data.year}</span>
              </div>
            </div>
          </div>

          {/* Right Column: Description */}
          <div className="col-span-1 md:col-span-8 md:pl-12">
            <p className="text-2xl md:text-3xl font-light leading-relaxed text-gray-700 dark:text-gray-300">
              {data.description}
            </p>
          </div>
        </div>

        {/* Gallery */}
        <div
          ref={galleryRef}
          className="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-12"
        >
          {data.gallery_images &&
            data.gallery_images.map((imgSrc, index) => (
              <div
                key={index}
                className={`gallery-img overflow-hidden rounded-xl ${index === 2 ? "md:col-span-2" : ""}`}
              >
                <img
                  src={imgSrc}
                  alt={`Gallery item ${index + 1}`}
                  loading="lazy"
                  className="w-full h-full object-cover aspect-4/3 md:aspect-auto hover:scale-105 transition-transform duration-700"
                />
              </div>
            ))}
        </div>
      </div>
    </div>
  );
};

export default ProjectDetail;
