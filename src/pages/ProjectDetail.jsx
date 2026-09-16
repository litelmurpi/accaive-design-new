import React, { useRef } from "react";
import { useParams, Link } from "react-router-dom";
import gsap from "gsap";
import { useGSAP } from "@gsap/react";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { ArrowLeft } from "lucide-react";
import { useProject } from "../hooks/useProjects";
import Skeleton from "../components/Skeleton";
import { usePageSEO } from "../hooks/usePageSEO";

gsap.registerPlugin(ScrollTrigger);

const ProjectDetail = () => {
  const { slug } = useParams();
  const { project: data, loading } = useProject(slug);
  const containerRef = useRef(null);
  const heroRef = useRef(null);
  const textRef = useRef(null);
  const galleryRef = useRef(null);
  const [heroError, setHeroError] = React.useState(false);

  usePageSEO({
    title: data?.title ? `${data.title} (${data.category || 'Architecture'})` : 'Project Portfolio',
    description: data?.description ? data.description.slice(0, 160) : 'Accaive Design Studio architecture project portfolio.',
    image: data?.hero_image,
    path: `/project/${slug}`,
  });

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
      <div className="bg-[#f8f8f8] dark:bg-[#0a0a0a] text-neutral-900 dark:text-neutral-100 min-h-screen">
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
      <div className="min-h-screen flex items-center justify-center font-serif text-3xl bg-[#f8f8f8] dark:bg-[#0a0a0a] text-neutral-900 dark:text-neutral-100">
        Project not found.
      </div>
    );

  return (
    <div
      ref={containerRef}
      className="bg-[#f8f8f8] dark:bg-[#0a0a0a] text-neutral-900 dark:text-neutral-100 min-h-screen transition-colors duration-500"
    >
      {/* Hero Section */}
      <div className="relative w-full h-[60vh] md:h-[80vh] overflow-hidden bg-neutral-900">
        {data.hero_image && !heroError ? (
          <img
            ref={heroRef}
            src={data.hero_image}
            alt={data.title}
            onError={() => setHeroError(true)}
            className="absolute w-full h-[120%] object-cover top-[-10%]"
          />
        ) : (
          <div className="absolute inset-0 bg-linear-to-b from-neutral-800 to-neutral-950 flex flex-col items-center justify-center p-6 text-center">
            <div className="w-16 h-16 rounded-full border border-white/10 flex items-center justify-center mb-4 text-white/30">
              <svg className="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.2} d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
              </svg>
            </div>
            <span className="font-serif text-3xl md:text-5xl text-white/50 tracking-wide block mb-2">{data.title}</span>
            <span className="text-xs uppercase tracking-widest text-white/40 font-mono">{data.category || "Architecture"}</span>
          </div>
        )}
        <div className="absolute inset-0 bg-black/30 pointer-events-none"></div>

        {/* Back Button */}
        <Link
          to="/case-studies"
          className="absolute top-32 left-6 md:left-12 z-10 inline-flex items-center gap-2 text-white hover:text-white/80 transition-all bg-black/40 hover:bg-black/60 px-5 py-2.5 rounded-full backdrop-blur-md border border-white/15 shadow-lg"
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
            <div className="text-xs uppercase tracking-widest text-neutral-500 dark:text-neutral-400 mb-4 font-medium">
              {data.category}
            </div>
            <h1 className="font-serif text-5xl md:text-6xl mb-8 leading-tight text-neutral-900 dark:text-white">
              {data.title}
            </h1>

            <div className="space-y-6 pt-8 border-t border-neutral-200 dark:border-neutral-800">
              <div>
                <span className="block text-xs uppercase tracking-widest text-neutral-500 dark:text-neutral-400 mb-1 font-medium">
                  Client
                </span>
                <span className="font-medium text-lg text-neutral-900 dark:text-white">{data.client}</span>
              </div>
              <div>
                <span className="block text-xs uppercase tracking-widest text-neutral-500 dark:text-neutral-400 mb-1 font-medium">
                  Year
                </span>
                <span className="font-medium text-lg text-neutral-900 dark:text-white">{data.year}</span>
              </div>
            </div>
          </div>

          {/* Right Column: Description */}
          <div className="col-span-1 md:col-span-8 md:pl-12">
            <p className="text-2xl md:text-3xl font-light leading-relaxed text-neutral-700 dark:text-neutral-200">
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
              <GalleryItem key={index} imgSrc={imgSrc} index={index} />
            ))}
        </div>
      </div>
    </div>
  );
};

const GalleryItem = ({ imgSrc, index }) => {
  const [error, setError] = React.useState(false);
  if (error || !imgSrc) return null;
  return (
    <div
      className={`gallery-img overflow-hidden rounded-xl ${index === 2 ? "md:col-span-2" : ""}`}
    >
      <img
        src={imgSrc}
        alt={`Gallery item ${index + 1}`}
        loading="lazy"
        onError={() => setError(true)}
        className="w-full h-full object-cover aspect-4/3 md:aspect-auto hover:scale-105 transition-transform duration-700"
      />
    </div>
  );
};

export default ProjectDetail;
