import React, { useRef, useMemo } from "react";
import { useParams, Link } from "react-router-dom";
import gsap from "gsap";
import { useGSAP } from "@gsap/react";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import {
  ArrowLeft,
  ArrowUpRight,
  MapPin,
  Calendar,
  Activity,
  Users,
  Building2,
  FolderDot
} from "lucide-react";
import { useProject, useProjects } from "../hooks/useProjects";
import Skeleton from "../components/Skeleton";
import { usePageSEO } from "../hooks/usePageSEO";
import Contact from "../components/Contact";

gsap.registerPlugin(ScrollTrigger);

const ProjectDetail = () => {
  const { slug } = useParams();
  const { project: data, loading } = useProject(slug);
  const { projects: allProjects } = useProjects();
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

  // Calculate Next & Previous Project
  const { nextProject, prevProject } = useMemo(() => {
    if (!allProjects || allProjects.length === 0 || !data) {
      return { nextProject: null, prevProject: null };
    }
    const currentIndex = allProjects.findIndex((p) => p.slug === slug || p.id === data.id);
    if (currentIndex === -1) return { nextProject: null, prevProject: null };
    
    const prev = currentIndex > 0 ? allProjects[currentIndex - 1] : allProjects[allProjects.length - 1];
    const next = currentIndex < allProjects.length - 1 ? allProjects[currentIndex + 1] : allProjects[0];
    return { nextProject: next, prevProject: prev };
  }, [allProjects, data, slug]);

  // Intelligent metadata parser: handle custom fields or parse if embedded in raw description
  const { cleanDescription, location, status, teamInCharge } = useMemo(() => {
    if (!data) return { cleanDescription: "", location: "", status: "", teamInCharge: [] };

    let loc = data.location || "";
    let stat = data.status || "";
    let team = [];

    if (Array.isArray(data.team_in_charge)) {
      team = data.team_in_charge;
    } else if (typeof data.team_in_charge === "string" && data.team_in_charge.trim()) {
      team = data.team_in_charge.split("\n").map((t) => t.trim()).filter(Boolean);
    }

    let desc = data.description || "";

    // Extract Team in Charge if embedded in description string
    if (team.length === 0 && desc.includes("Team in Charge")) {
      const match = desc.match(/Team in Charge[s]?\s*:\s*([\s\S]*?)(?=\n\s*(?:Status|Client|Location|\n\n\n|$))/i);
      if (match && match[1]) {
        team = match[1]
          .split("\n")
          .map((line) => line.replace(/^[-*•]\s*/, "").trim())
          .filter(Boolean);
        desc = desc.replace(/Team in Charge[s]?\s*:\s*[\s\S]*?(?=\n\s*Status|\n\n|$)/i, "").trim();
      }
    }

    // Extract Status if embedded in description string
    if (!stat && desc.includes("Status")) {
      const statusMatch = desc.match(/Status\s*:\s*([^\n]+)/i);
      if (statusMatch && statusMatch[1]) {
        stat = statusMatch[1].trim();
        desc = desc.replace(/Status\s*:\s*[^\n]+/i, "").trim();
      }
    }

    // Extract Location if embedded in description string
    if (!loc && desc.includes("Location")) {
      const locMatch = desc.match(/Location\s*:\s*([^\n]+)/i);
      if (locMatch && locMatch[1]) {
        loc = locMatch[1].trim();
        desc = desc.replace(/Location\s*:\s*[^\n]+/i, "").trim();
      }
    }

    // Clean leading/trailing blank lines
    desc = desc.replace(/^\s+|\s+$/g, "");

    return {
      cleanDescription: desc,
      location: loc,
      status: stat,
      teamInCharge: team,
    };
  }, [data]);

  // Split description into well-spaced paragraphs
  const descriptionParagraphs = useMemo(() => {
    if (!cleanDescription) return [];
    return cleanDescription
      .split(/\n\s*\n/)
      .map((p) => p.trim())
      .filter(Boolean);
  }, [cleanDescription]);

  useGSAP(
    () => {
      // Hero Image Parallax
      if (heroRef.current) {
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
      }

      // Text Entrance
      if (textRef.current) {
        gsap.fromTo(
          textRef.current,
          { y: 40, opacity: 0 },
          {
            y: 0,
            opacity: 1,
            duration: 1,
            ease: "power3.out",
            clearProps: "all",
            scrollTrigger: {
              trigger: textRef.current,
              start: "top 85%",
            },
          },
        );
      }

      // Gallery Items Entrance
      const images = gsap.utils.toArray(".gallery-img");
      images.forEach((img) => {
        gsap.fromTo(
          img,
          { y: 50, opacity: 0 },
          {
            y: 0,
            opacity: 1,
            duration: 0.9,
            ease: "power3.out",
            clearProps: "all",
            scrollTrigger: {
              trigger: img,
              start: "top 85%",
            },
          },
        );
      });
    },
    { dependencies: [data], scope: containerRef },
  );

  if (loading) {
    return (
      <div className="bg-[#f8f8f8] dark:bg-[#0a0a0a] text-neutral-900 dark:text-neutral-100 min-h-screen">
        <div id="project-hero" className="w-full h-[65vh] md:h-[80vh] bg-neutral-900 overflow-hidden relative">
          <Skeleton className="w-full h-full bg-neutral-800/80" />
        </div>
        <div className="max-w-7xl mx-auto px-6 md:px-12 py-20">
          <div className="grid grid-cols-1 md:grid-cols-12 gap-12 mb-24">
            <div className="col-span-1 md:col-span-4 space-y-4">
              <Skeleton className="w-1/4 h-4" />
              <Skeleton className="w-3/4 h-12" />
              <Skeleton className="w-full h-40" />
            </div>
            <div className="col-span-1 md:col-span-8 space-y-4">
              <Skeleton className="w-full h-6" />
              <Skeleton className="w-full h-6" />
              <Skeleton className="w-4/5 h-6" />
            </div>
          </div>
        </div>
      </div>
    );
  }

  if (!data)
    return (
      <div className="min-h-screen flex flex-col items-center justify-center font-serif text-2xl bg-[#f8f8f8] dark:bg-[#0a0a0a] text-neutral-900 dark:text-neutral-100 px-6">
        <p className="mb-6">Project not found.</p>
        <Link
          to="/case-studies"
          className="text-sm font-sans underline underline-offset-4 tracking-wider uppercase opacity-70 hover:opacity-100 transition-opacity"
        >
          Return to Archive
        </Link>
      </div>
    );

  return (
    <div
      ref={containerRef}
      className="bg-[#fbfbfb] dark:bg-[#0a0a0a] text-neutral-900 dark:text-neutral-100 min-h-screen transition-colors duration-500"
    >
      {/* 1. Hero Section */}
      <div
        id="project-hero"
        className="relative w-full h-[65vh] md:h-[80vh] overflow-hidden bg-neutral-900"
      >
        {data.hero_image && !heroError ? (
          <img
            ref={heroRef}
            src={data.hero_image}
            alt={data.title}
            onError={() => setHeroError(true)}
            className="absolute w-full h-[120%] object-cover top-[-10%]"
          />
        ) : (
          <div className="absolute inset-0 bg-gradient-to-b from-neutral-800 to-neutral-950 flex flex-col items-center justify-center p-6 text-center">
            <div className="w-16 h-16 rounded-full border border-white/10 flex items-center justify-center mb-4 text-white/30">
              <Building2 className="w-8 h-8 stroke-[1.2]" />
            </div>
            <span className="font-serif text-3xl md:text-5xl text-white/50 tracking-wide block mb-2">{data.title}</span>
            <span className="text-xs uppercase tracking-widest text-white/40 font-mono">{data.category || "Architecture"}</span>
          </div>
        )}
        <div className="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-black/40 pointer-events-none"></div>

        {/* Back Button */}
        <Link
          to="/case-studies"
          className="absolute top-28 left-6 md:left-12 z-20 inline-flex items-center gap-2 text-white/90 hover:text-white transition-all bg-black/40 hover:bg-black/70 px-4 py-2 rounded-full backdrop-blur-md border border-white/15 shadow-lg text-xs font-mono uppercase tracking-widest"
        >
          <ArrowLeft size={14} /> Back to Projects
        </Link>

        {/* Hero Bottom Banner */}
        <div className="absolute bottom-8 left-6 md:left-12 right-6 md:right-12 z-10 flex flex-col md:flex-row md:items-end justify-between gap-4 pointer-events-none">
          <div>
            <span className="inline-block px-3 py-1 mb-2 bg-white/10 backdrop-blur-md border border-white/15 text-[11px] font-mono uppercase tracking-widest text-white/90 rounded-sm">
              {data.category || "Architecture"}
            </span>
            <h1 className="font-serif text-3xl sm:text-4xl md:text-5xl lg:text-6xl text-white font-normal leading-[1.1] max-w-4xl drop-shadow-md">
              {data.title}
            </h1>
          </div>
          {status && (
            <div className="bg-black/60 backdrop-blur-md px-4 py-2 border border-white/15 rounded-sm self-start md:self-end flex items-center gap-2">
              <span className="relative flex h-2 w-2">
                <span className="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                <span className="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
              </span>
              <div>
                <span className="text-[9px] font-mono uppercase tracking-widest text-white/50 block leading-none mb-1">Status</span>
                <span className="text-xs md:text-sm font-medium text-white tracking-wide">
                  {status}
                </span>
              </div>
            </div>
          )}
        </div>
      </div>

      {/* 2. Content & Project Specification Grid */}
      <div className="max-w-7xl mx-auto px-6 md:px-12 py-16 md:py-24">
        <div
          ref={textRef}
          className="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start"
        >
          {/* Left Column: Structured Project Metadata (Sidebar) */}
          <aside className="lg:col-span-4 lg:sticky lg:top-32 space-y-8 bg-neutral-50 dark:bg-[#111111] p-6 sm:p-8 rounded-sm border border-black/5 dark:border-white/5">
            <div>
              <span className="text-[10px] font-mono uppercase tracking-[0.25em] text-neutral-400 dark:text-neutral-500 block mb-2">
                Project Specification
              </span>
              <h2 className="font-serif text-xl md:text-2xl text-neutral-900 dark:text-white font-medium">
                Information & Credits
              </h2>
            </div>

            <div className="space-y-5 pt-4 border-t border-neutral-200/80 dark:border-neutral-800 text-sm">
              {/* Location */}
              {location && (
                <div className="flex items-start gap-3">
                  <MapPin className="w-4 h-4 text-neutral-400 dark:text-neutral-500 mt-0.5 shrink-0" />
                  <div>
                    <span className="block text-[11px] font-mono uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                      Location
                    </span>
                    <span className="font-medium text-neutral-900 dark:text-white text-sm">
                      {location}
                    </span>
                  </div>
                </div>
              )}

              {/* Status */}
              {status && (
                <div className="flex items-start gap-3">
                  <Activity className="w-4 h-4 text-emerald-500 mt-0.5 shrink-0" />
                  <div>
                    <span className="block text-[11px] font-mono uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                      Project Status
                    </span>
                    <span className="font-medium text-neutral-900 dark:text-white text-sm">
                      {status}
                    </span>
                  </div>
                </div>
              )}

              {/* Year */}
              {data.year && (
                <div className="flex items-start gap-3">
                  <Calendar className="w-4 h-4 text-neutral-400 dark:text-neutral-500 mt-0.5 shrink-0" />
                  <div>
                    <span className="block text-[11px] font-mono uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                      Year
                    </span>
                    <span className="font-medium text-neutral-900 dark:text-white text-sm">
                      {data.year}
                    </span>
                  </div>
                </div>
              )}

              {/* Client */}
              {data.client && (
                <div className="flex items-start gap-3">
                  <Building2 className="w-4 h-4 text-neutral-400 dark:text-neutral-500 mt-0.5 shrink-0" />
                  <div>
                    <span className="block text-[11px] font-mono uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                      Client
                    </span>
                    <span className="font-medium text-neutral-900 dark:text-white text-sm">
                      {data.client}
                    </span>
                  </div>
                </div>
              )}

              {/* Category */}
              {data.category && (
                <div className="flex items-start gap-3">
                  <FolderDot className="w-4 h-4 text-neutral-400 dark:text-neutral-500 mt-0.5 shrink-0" />
                  <div>
                    <span className="block text-[11px] font-mono uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                      Typology
                    </span>
                    <span className="font-medium text-neutral-900 dark:text-white text-sm">
                      {data.category}
                    </span>
                  </div>
                </div>
              )}

              {/* Team in Charge */}
              {teamInCharge && teamInCharge.length > 0 && (
                <div className="pt-4 border-t border-neutral-200/80 dark:border-neutral-800">
                  <div className="flex items-center gap-2 mb-3">
                    <Users className="w-4 h-4 text-neutral-400 dark:text-neutral-500 shrink-0" />
                    <span className="block text-[11px] font-mono uppercase tracking-wider text-neutral-500 dark:text-neutral-400">
                      Team in Charge
                    </span>
                  </div>
                  <ul className="space-y-1.5 pl-6 border-l border-black/10 dark:border-white/10">
                    {teamInCharge.map((member, idx) => (
                      <li
                        key={idx}
                        className="text-sm font-medium text-neutral-800 dark:text-neutral-200"
                      >
                        {member}
                      </li>
                    ))}
                  </ul>
                </div>
              )}
            </div>
          </aside>

          {/* Right Column: Architectural Narrative & Description */}
          <article className="lg:col-span-8 lg:pl-6 space-y-8">
            <div className="border-b border-black/10 dark:border-white/10 pb-6">
              <span className="text-xs font-mono uppercase tracking-[0.2em] text-neutral-400 dark:text-neutral-500 block mb-3">
                Spatial Narrative & Design Concept
              </span>
              <h3 className="font-serif text-2xl md:text-3xl text-neutral-900 dark:text-white leading-snug">
                Architectural Intent & Context
              </h3>
            </div>

            {/* Structured, highly legible reading layout */}
            <div className="space-y-6 text-neutral-700 dark:text-neutral-300 font-sans font-light leading-[1.85] text-base md:text-lg">
              {descriptionParagraphs.length > 0 ? (
                descriptionParagraphs.map((paragraph, idx) => (
                  <p
                    key={idx}
                    className={
                      idx === 0
                        ? "text-lg md:text-xl font-normal text-neutral-900 dark:text-neutral-100 leading-relaxed"
                        : "text-base md:text-[1.0625rem] text-neutral-600 dark:text-neutral-300"
                    }
                  >
                    {paragraph}
                  </p>
                ))
              ) : (
                <p className="text-base md:text-lg text-neutral-600 dark:text-neutral-300">
                  {data.description || "Detailed project documentation coming soon."}
                </p>
              )}
            </div>

            {/* Quote / Highlight if available */}
            <div className="mt-8 p-6 md:p-8 bg-neutral-100/70 dark:bg-white/5 border-l-2 border-neutral-900 dark:border-white rounded-r-sm">
              <p className="font-serif italic text-base md:text-lg text-neutral-800 dark:text-neutral-200">
                “Architecture becomes meaningful not when it commands the landscape, but when it holds space for memory and human continuity.”
              </p>
              <span className="block mt-2 text-xs font-mono tracking-wider uppercase text-neutral-500">
                Accaive Design Studio
              </span>
            </div>
          </article>
        </div>

        {/* 3. Visual Gallery Section */}
        {data.gallery_images && data.gallery_images.length > 0 && (
          <section className="mt-24 pt-16 border-t border-black/10 dark:border-white/10">
            <div className="flex flex-col md:flex-row md:items-end justify-between mb-12">
              <div>
                <span className="text-xs font-mono uppercase tracking-[0.2em] text-neutral-400 dark:text-neutral-500 block mb-2">
                  Visual Documentation
                </span>
                <h3 className="font-serif text-3xl md:text-4xl text-neutral-900 dark:text-white">
                  Gallery & Studies
                </h3>
              </div>
              <p className="text-xs font-mono text-neutral-500 mt-2 md:mt-0 uppercase tracking-wider">
                {data.gallery_images.length} Captured Perspectives
              </p>
            </div>

            <div
              ref={galleryRef}
              className="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-10"
            >
              {data.gallery_images.map((imgSrc, index) => (
                <GalleryItem key={index} imgSrc={imgSrc} index={index} />
              ))}
            </div>
          </section>
        )}

        {/* 4. Next Project Navigation */}
        {nextProject && (
          <section className="mt-28 pt-12 border-t border-black/10 dark:border-white/10 flex flex-col sm:flex-row items-center justify-between gap-6">
            <div>
              <span className="text-xs font-mono uppercase tracking-widest text-neutral-400 dark:text-neutral-500 block mb-1">
                Next Project
              </span>
              <Link
                to={`/project/${nextProject.slug}`}
                className="group font-serif text-2xl md:text-3xl text-neutral-900 dark:text-white hover:underline flex items-center gap-2"
              >
                <span>{nextProject.title}</span>
                <ArrowUpRight className="w-5 h-5 group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform" />
              </Link>
            </div>

            <div className="flex items-center gap-4">
              {prevProject && (
                <Link
                  to={`/project/${prevProject.slug}`}
                  className="px-5 py-2.5 rounded-full border border-neutral-300 dark:border-neutral-700 text-xs font-mono uppercase tracking-wider hover:bg-neutral-900 hover:text-white dark:hover:bg-white dark:hover:text-black transition-colors"
                >
                  Previous
                </Link>
              )}
              <Link
                to="/case-studies"
                className="px-5 py-2.5 rounded-full bg-neutral-900 text-white dark:bg-white dark:text-black text-xs font-mono uppercase tracking-wider hover:opacity-80 transition-opacity"
              >
                All Projects
              </Link>
            </div>
          </section>
        )}
      </div>

      {/* 5. Contact Section */}
      <Contact />
    </div>
  );
};

const GalleryItem = ({ imgSrc, index }) => {
  const [error, setError] = React.useState(false);
  if (error || !imgSrc) return null;
  return (
    <div
      className={`gallery-img overflow-hidden rounded-sm bg-neutral-100 dark:bg-neutral-900 ${
        index === 2 ? "md:col-span-2 aspect-[16/9]" : "aspect-[4/3] md:aspect-[16/11]"
      } relative group`}
    >
      <img
        src={imgSrc}
        alt={`Gallery perspective ${index + 1}`}
        loading="lazy"
        onError={() => setError(true)}
        className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out"
      />
      <div className="absolute bottom-3 right-3 bg-black/70 backdrop-blur-sm text-[10px] font-mono text-white/80 px-2.5 py-1 rounded-sm uppercase tracking-wider pointer-events-none">
        0{index + 1}
      </div>
    </div>
  );
};

export default ProjectDetail;

