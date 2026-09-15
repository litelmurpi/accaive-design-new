import React, { useRef } from "react";
import { Link } from "react-router-dom";
import { ArrowRight, ArrowUpRight, Compass, Layers, ShieldCheck, Sparkles, MapPin } from "lucide-react";
import gsap from "gsap";
import { useGSAP } from "@gsap/react";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { useSettings } from "../hooks/useSecondary";
import { useTeam } from "../hooks/useTeam";
import { usePageSEO } from "../hooks/usePageSEO";
import Contact from "../components/Contact";
import Skeleton from "../components/Skeleton";

gsap.registerPlugin(ScrollTrigger);

const defaultPillars = [
  {
    number: "01",
    title: "Tectonic Honesty",
    tagline: "Structure as unadorned sculpture",
    desc: "We celebrate raw materiality—poured concrete, untreated stone, native timber, and exposed steel. Every structural element communicates its load and purpose with uncompromising integrity.",
    icon: Layers,
  },
  {
    number: "02",
    title: "Contextual Memory",
    tagline: "Rooted in geography and cultural depth",
    desc: "Our architecture begins with a listening process. Born between the historic craftsmanship of Kotagede and the urban dynamism of Jakarta, each intervention honors regional climatology and collective memory.",
    icon: Compass,
  },
  {
    number: "03",
    title: "Spatial Poetry",
    tagline: "Choreography of light, void, and shadow",
    desc: "We treat natural daylight as the primary building material. Through monumental openings, deep thresholds, and serene voids, spaces evoke a sense of quiet sanctuary and emotional reverence.",
    icon: Sparkles,
  },
  {
    number: "04",
    title: "Sustainable Longevity",
    tagline: "Designed to age with grace and patina",
    desc: "True luxury is endurance. We craft buildings and interiors engineered to outlast transient design trends, developing rich textures over decades rather than demanding frequent replacement.",
    icon: ShieldCheck,
  },
];

const defaultDisciplines = [
  {
    id: "architecture",
    title: "Architecture",
    scope: "Monolithic residences, cultural pavilions, civic landmarks & commercial towers.",
    image: "https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=1200&auto=format&fit=crop",
    metric: "24+ Completed Works",
  },
  {
    id: "interior",
    title: "Interior Architecture",
    scope: "Atmospheric sensory spaces, bespoke joinery, acoustic balance & tactile curation.",
    image: "https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?q=80&w=1200&auto=format&fit=crop",
    metric: "18+ Curated Spaces",
  },
  {
    id: "landscape",
    title: "Landscape Urbanism",
    scope: "Biophilic public realms, native botanical integration & microclimate orchestration.",
    image: "https://images.unsplash.com/photo-1512917774080-9991f1c4c750?q=80&w=1200&auto=format&fit=crop",
    metric: "12+ Masterplans",
  },
  {
    id: "reuse",
    title: "Adaptive Reuse",
    scope: "Breathing contemporary relevance and structural vitality into historic colonial fabrics.",
    image: "https://images.unsplash.com/photo-1541888086225-ee9b418fb5d8?q=80&w=1200&auto=format&fit=crop",
    metric: "8+ Restorations",
  },
];

const defaultMilestones = [
  { value: "40+", label: "Commissioned Works", sub: "Across Indonesia & Southeast Asia" },
  { value: "02", label: "Studio Hubs", sub: "Kotagede (Yogyakarta) & Jakarta" },
  { value: "15+", label: "Architects & Makers", sub: "Multidisciplinary design collective" },
  { value: "100%", label: "Material Authenticity", sub: "Context-responsive construction" },
];

const About = () => {
  const { settings } = useSettings();
  const { team: members, loading: teamLoading } = useTeam();

  const containerRef = useRef(null);
  const heroImageRef = useRef(null);
  const heroTextRef = useRef(null);
  const manifestoRef = useRef(null);
  const pillarsRef = useRef(null);

  // Dynamic CMS Settings with Editorial Defaults
  const pageTitle = settings?.about_page_title || "About Accaive — Architecture & Built Environments";
  const heroBadge = settings?.about_hero_badge || "Accaive Design Studio — Est. Yogyakarta & Jakarta";
  const heroHeading =
    settings?.about_hero_heading ||
    "Architecture as a dialogue between tectonic permanence and poetic restraint.";
  const heroDescription =
    settings?.about_hero_description ||
    "We are an interdisciplinary studio exploring the thresholds between brutalist structural honesty, tropical climate consciousness, and contemporary understated luxury.";

  const manifestoQuote =
    settings?.about_manifesto_quote ||
    "We do not build to decorate landscapes; we build to frame human existence with spatial truth and quiet dignity.";

  const manifestoText1 =
    settings?.about_manifesto_p1 ||
    "Founded with dual hearts in Kotagede (Yogyakarta) and Jakarta, Accaive navigates the continuous friction between timeless craftsmanship and high-density urban acceleration. In Kotagede, we study the longevity of ancient stone, hand-wrought silver, and traditional Javanese spatial hierarchy. In Jakarta, we test these principles against modern structural scale and forward-thinking sustainability.";

  const manifestoText2 =
    settings?.about_manifesto_p2 ||
    "Our approach is uncompromisingly tactile. Rather than covering surfaces with ephemeral veneers, we sculpt spaces from monolithic concrete, local andesite stone, repurposed teak, and floor-to-ceiling glass. The result is an architecture that does not shout for attention, but commands an enduring, contemplative presence.";

  usePageSEO({
    title: pageTitle,
    description: "Learn about Accaive Design Studio: our dual roots in Kotagede & Jakarta, brutalist luxury philosophy, core architectural pillars, and multidisciplinary practice.",
    path: "/about",
  });

  useGSAP(
    () => {
      // Hero entrance
      gsap.from(heroTextRef.current, {
        y: 40,
        opacity: 0,
        duration: 1.2,
        ease: "power3.out",
      });

      // Hero image parallax
      if (heroImageRef.current) {
        gsap.to(heroImageRef.current, {
          y: -80,
          scrollTrigger: {
            trigger: containerRef.current,
            start: "top top",
            end: "bottom top",
            scrub: 1.2,
          },
        });
      }

      // Manifesto reveal
      if (manifestoRef.current) {
        const items = manifestoRef.current.querySelectorAll(".reveal-item");
        if (items.length > 0) {
          gsap.fromTo(
            items,
            { y: 30, opacity: 0 },
            {
              y: 0,
              opacity: 1,
              duration: 0.8,
              stagger: 0.12,
              ease: "power2.out",
              clearProps: "transform,opacity",
              scrollTrigger: {
                trigger: manifestoRef.current,
                start: "top 85%",
                once: true,
              },
            },
          );
        }
      }

      // Pillars reveal
      if (pillarsRef.current) {
        const cards = pillarsRef.current.querySelectorAll(".pillar-card");
        if (cards.length > 0) {
          gsap.fromTo(
            cards,
            { y: 35, opacity: 0 },
            {
              y: 0,
              opacity: 1,
              duration: 0.7,
              stagger: 0.1,
              ease: "power2.out",
              clearProps: "transform,opacity",
              scrollTrigger: {
                trigger: pillarsRef.current,
                start: "top 85%",
                once: true,
              },
            },
          );
        }
      }

      const timer = setTimeout(() => {
        ScrollTrigger.refresh();
      }, 250);

      return () => clearTimeout(timer);
    },
    { scope: containerRef },
  );

  return (
    <div
      ref={containerRef}
      className="bg-white text-black min-h-screen overflow-x-hidden selection:bg-black selection:text-white"
    >
      {/* 1. MONUMENTAL HERO SECTION */}
      <section className="relative pt-36 md:pt-48 pb-20 md:pb-32 px-6 md:px-12 max-w-7xl mx-auto">
        <div ref={heroTextRef} className="max-w-5xl">
          <div className="inline-flex items-center gap-3 px-3 py-1.5 border border-black/15 rounded-full text-xs font-mono uppercase tracking-widest text-black/60 mb-8 md:mb-12">
            <span className="w-2 h-2 rounded-full bg-black"></span>
            {heroBadge}
          </div>

          <h1 className="font-serif text-4xl sm:text-6xl md:text-7xl lg:text-8xl leading-[1.05] tracking-tight mb-8 md:mb-12 text-black">
            {heroHeading}
          </h1>

          <p className="text-lg md:text-2xl text-black/70 font-light leading-relaxed max-w-3xl">
            {heroDescription}
          </p>
        </div>

        {/* Hero Visual Monument */}
        <div className="mt-16 md:mt-24 relative overflow-hidden rounded-sm aspect-[16/9] md:aspect-[21/9] bg-neutral-100 shadow-2xl">
          <img
            ref={heroImageRef}
            src="https://images.unsplash.com/photo-1600607686527-6fb886090705?q=80&w=2727&auto=format&fit=crop"
            alt="Accaive Design Studio Architecture"
            onLoad={() => ScrollTrigger.refresh()}
            className="w-full h-[120%] -top-[10%] relative object-cover filter contrast-[1.03] grayscale hover:grayscale-0 transition-all duration-1000 ease-out"
          />
          <div className="absolute bottom-4 right-4 md:bottom-8 md:right-8 bg-black/80 backdrop-blur-md text-white text-xs font-mono uppercase tracking-wider px-4 py-2 border border-white/10 rounded-sm">
            The Void House — Monolithic Form & Light
          </div>
        </div>
      </section>

      {/* 2. STUDIO MANIFESTO & ORIGIN DUALISM */}
      <section
        ref={manifestoRef}
        className="py-20 md:py-32 px-6 md:px-12 border-t border-black/10 bg-neutral-50/60"
      >
        <div className="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">
          <div className="lg:col-span-5 reveal-item lg:sticky lg:top-28">
            <span className="text-xs uppercase font-mono tracking-widest text-black/50 block mb-4">
              Studio Manifesto
            </span>
            <blockquote className="font-serif text-2xl md:text-4xl leading-snug text-black italic">
              "{manifestoQuote}"
            </blockquote>
            <div className="w-16 h-0.5 bg-black mt-8"></div>
          </div>

          <div className="lg:col-span-7 space-y-6 md:space-y-8 text-base md:text-lg text-black/75 font-light leading-relaxed reveal-item">
            <p className="first-letter:font-serif first-letter:text-5xl first-letter:float-left first-letter:mr-3 first-letter:text-black">
              {manifestoText1}
            </p>
            <p>{manifestoText2}</p>

            <div className="pt-8 border-t border-black/10 grid grid-cols-1 sm:grid-cols-2 gap-6">
              <div>
                <h4 className="font-serif text-xl font-medium text-black mb-1">
                  Kotagede Atelier
                </h4>
                <p className="text-xs text-black/60 font-mono">
                  Yogyakarta, Indonesia — Material & Heritage Lab
                </p>
              </div>
              <div>
                <h4 className="font-serif text-xl font-medium text-black mb-1">
                  Jakarta Strategic Lab
                </h4>
                <p className="text-xs text-black/60 font-mono">
                  SCBD, Jakarta — Urban Scale & Masterplanning
                </p>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* 3. CORE ARCHITECTURAL PILLARS */}
      <section ref={pillarsRef} className="py-20 md:py-32 px-6 md:px-12 max-w-7xl mx-auto">
        <div className="flex flex-col md:flex-row md:items-end justify-between mb-16 border-b border-black/10 pb-8">
          <div>
            <span className="text-xs font-mono uppercase tracking-widest text-black/50 block mb-3">
              Guiding Ethos
            </span>
            <h2 className="font-serif text-3xl md:text-5xl text-black">
              Our Core Architectural Pillars
            </h2>
          </div>
          <p className="text-sm md:text-base text-black/60 max-w-md mt-4 md:mt-0">
            Four fundamental convictions that govern every sketch, material decision, and finished space we deliver.
          </p>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12">
          {defaultPillars.map((pillar, idx) => {
            const IconComponent = pillar.icon;
            return (
              <div
                key={idx}
                className="pillar-card p-8 md:p-10 border border-black/10 bg-white hover:border-black/40 transition-all duration-500 rounded-sm group relative flex flex-col justify-between"
              >
                <div>
                  <div className="flex items-center justify-between mb-8">
                    <span className="font-mono text-xs font-bold uppercase tracking-widest text-black/40 group-hover:text-black transition-colors">
                      Pillar {pillar.number}
                    </span>
                    <IconComponent className="w-5 h-5 text-black/40 group-hover:text-black group-hover:scale-110 transition-all duration-300" />
                  </div>
                  <h3 className="font-serif text-2xl md:text-3xl text-black mb-2 group-hover:translate-x-1 transition-transform duration-300">
                    {pillar.title}
                  </h3>
                  <p className="text-xs font-mono uppercase tracking-wider text-black/50 mb-6">
                    {pillar.tagline}
                  </p>
                  <p className="text-sm md:text-base text-black/70 font-light leading-relaxed">
                    {pillar.desc}
                  </p>
                </div>
                <div className="mt-8 pt-6 border-t border-black/5 flex items-center justify-between text-xs font-mono uppercase tracking-widest text-black/40 group-hover:text-black">
                  <span>Accaive Standard</span>
                  <ArrowRight className="w-4 h-4 opacity-0 group-hover:opacity-100 group-hover:translate-x-1 transition-all duration-300" />
                </div>
              </div>
            );
          })}
        </div>
      </section>

      {/* 4. DISCIPLINES & PRACTICE */}
      <section className="py-20 md:py-32 px-6 md:px-12 bg-[#0a0a0a] text-white">
        <div className="max-w-7xl mx-auto">
          <div className="flex flex-col md:flex-row md:items-end justify-between mb-16 border-b border-white/10 pb-8">
            <div>
              <span className="text-xs font-mono uppercase tracking-widest text-white/50 block mb-3">
                Disciplines
              </span>
              <h2 className="font-serif text-3xl md:text-5xl text-white">
                The Accaive Practice
              </h2>
            </div>
            <p className="text-sm md:text-base text-white/60 max-w-md mt-4 md:mt-0 font-light">
              From intimate residential sanctuaries to broad-scale urban ecosystems, we deliver unified architectural interventions.
            </p>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
            {defaultDisciplines.map((item, idx) => (
              <div
                key={idx}
                className="group relative overflow-hidden border border-white/10 rounded-sm bg-white/5 p-8 flex flex-col justify-between min-h-[340px] hover:border-white/30 transition-all duration-500"
              >
                {/* Background Image on Hover */}
                <div className="absolute inset-0 z-0 opacity-15 group-hover:opacity-30 group-hover:scale-105 transition-all duration-700 ease-out">
                  <img
                    src={item.image}
                    alt={item.title}
                    className="w-full h-full object-cover grayscale"
                  />
                </div>
                <div className="absolute inset-0 bg-gradient-to-t from-[#0a0a0a] via-[#0a0a0a]/80 to-transparent z-0"></div>

                <div className="relative z-10">
                  <div className="flex justify-between items-center mb-6">
                    <span className="font-mono text-xs text-white/40 tracking-widest uppercase">
                      0{idx + 1}
                    </span>
                    <span className="font-mono text-xs px-2.5 py-1 rounded-full border border-white/20 text-white/70">
                      {item.metric}
                    </span>
                  </div>
                  <h3 className="font-serif text-2xl md:text-3xl text-white mb-3">
                    {item.title}
                  </h3>
                  <p className="text-sm text-white/70 font-light leading-relaxed max-w-md">
                    {item.scope}
                  </p>
                </div>

                <div className="relative z-10 pt-6 border-t border-white/10 flex items-center justify-between">
                  <Link
                    to="/case-studies"
                    className="inline-flex items-center gap-2 text-xs font-mono uppercase tracking-widest text-white/80 group-hover:text-white transition-colors"
                  >
                    <span>View Projects</span>
                    <ArrowUpRight className="w-4 h-4 group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-transform" />
                  </Link>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* 5. STUDIO BY THE NUMBERS */}
      <section className="py-20 md:py-28 px-6 md:px-12 max-w-7xl mx-auto border-b border-black/10">
        <div className="grid grid-cols-2 lg:grid-cols-4 gap-8 md:gap-12">
          {defaultMilestones.map((item, idx) => (
            <div key={idx} className="flex flex-col">
              <span className="font-serif text-4xl sm:text-6xl md:text-7xl text-black mb-2">
                {item.value}
              </span>
              <span className="text-sm md:text-base font-medium text-black mb-1">
                {item.label}
              </span>
              <span className="text-xs text-black/50 font-mono">
                {item.sub}
              </span>
            </div>
          ))}
        </div>
      </section>

      {/* 6. DUAL STUDIOS: KOTAGEDE & JAKARTA */}
      <section className="py-20 md:py-32 px-6 md:px-12 max-w-7xl mx-auto">
        <div className="flex flex-col md:flex-row md:items-end justify-between mb-16">
          <div>
            <span className="text-xs font-mono uppercase tracking-widest text-black/50 block mb-3">
              Locations
            </span>
            <h2 className="font-serif text-3xl md:text-5xl text-black">
              Two Studios. One Philosophy.
            </h2>
          </div>
          <p className="text-sm md:text-base text-black/60 max-w-md mt-4 md:mt-0 font-light">
            Our physical presence allows us to balance artisanal material prototyping with large-scale architectural execution.
          </p>
        </div>

        <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">
          {/* Kotagede Atelier */}
          <div className="border border-black/10 rounded-sm overflow-hidden group bg-neutral-50 flex flex-col justify-between">
            <div className="aspect-[16/10] overflow-hidden relative">
              <img
                src="https://images.unsplash.com/photo-1518998053901-5348d3969105?q=80&w=1200&auto=format&fit=crop"
                alt="Kotagede Yogyakarta Studio"
                className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out"
              />
              <div className="absolute top-4 left-4 bg-black/80 backdrop-blur-sm text-white text-xs font-mono px-3 py-1 uppercase tracking-wider rounded-sm flex items-center gap-1.5">
                <MapPin className="w-3.5 h-3.5" />
                Kotagede, Yogyakarta
              </div>
            </div>
            <div className="p-8 md:p-10 flex-1 flex flex-col justify-between">
              <div>
                <h3 className="font-serif text-2xl md:text-3xl text-black mb-2">
                  The Sanctuary & Material Workshop
                </h3>
                <p className="text-xs font-mono uppercase tracking-wider text-black/50 mb-4">
                  Craft Prototyping, Heritage Dialogue & Research
                </p>
                <p className="text-sm md:text-base text-black/70 font-light leading-relaxed mb-6">
                  Nestled in the historic silverware and stone-carving enclave of Kotagede, this studio acts as our tactile testing ground for joinery, raw finishes, and natural light studies.
                </p>
              </div>
              <div className="text-xs font-mono text-black/50 pt-4 border-t border-black/10">
                Visiting by appointment only
              </div>
            </div>
          </div>

          {/* Jakarta Studio */}
          <div className="border border-black/10 rounded-sm overflow-hidden group bg-neutral-50 flex flex-col justify-between">
            <div className="aspect-[16/10] overflow-hidden relative">
              <img
                src="https://images.unsplash.com/photo-1486718448742-163732cd1544?q=80&w=1200&auto=format&fit=crop"
                alt="Jakarta Urban Studio"
                className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out"
              />
              <div className="absolute top-4 left-4 bg-black/80 backdrop-blur-sm text-white text-xs font-mono px-3 py-1 uppercase tracking-wider rounded-sm flex items-center gap-1.5">
                <MapPin className="w-3.5 h-3.5" />
                SCBD, Jakarta
              </div>
            </div>
            <div className="p-8 md:p-10 flex-1 flex flex-col justify-between">
              <div>
                <h3 className="font-serif text-2xl md:text-3xl text-black mb-2">
                  The Urban & Strategic Lab
                </h3>
                <p className="text-xs font-mono uppercase tracking-wider text-black/50 mb-4">
                  Commercial Architecture, Masterplanning & Client Hub
                </p>
                <p className="text-sm md:text-base text-black/70 font-light leading-relaxed mb-6">
                  Positioned at the nexus of Indonesia's business capital, our Jakarta studio drives large-scale urban interventions, mixed-use commercial headquarters, and client collaborations.
                </p>
              </div>
              <div className="text-xs font-mono text-black/50 pt-4 border-t border-black/10">
                Open Monday – Friday
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* 7. THE COLLECTIVE & LEADERSHIP */}
      <section className="py-20 md:py-32 px-6 md:px-12 bg-neutral-100 border-t border-black/10">
        <div className="max-w-7xl mx-auto">
          <div className="flex flex-col md:flex-row md:items-end justify-between mb-16">
            <div>
              <span className="text-xs font-mono uppercase tracking-widest text-black/50 block mb-3">
                The Makers
              </span>
              <h2 className="font-serif text-3xl md:text-5xl text-black">
                Leadership & Collective
              </h2>
            </div>
            <div className="mt-4 md:mt-0">
              <Link
                to="/team"
                className="inline-flex items-center gap-2 text-xs font-mono uppercase tracking-widest text-black hover:text-black/60 transition-colors border-b border-black pb-1"
              >
                <span>View All Team Members</span>
                <ArrowRight className="w-4 h-4" />
              </Link>
            </div>
          </div>

          <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 md:gap-6">
            {teamLoading
              ? Array(6)
                  .fill(0)
                  .map((_, idx) => (
                    <div key={idx} className="space-y-3">
                      <Skeleton className="w-full aspect-[3/4] rounded-sm" />
                      <Skeleton className="w-3/4 h-4" />
                      <Skeleton className="w-1/2 h-3" />
                    </div>
                  ))
              : members.slice(0, 6).map((member, idx) => (
                  <div key={member.id || idx} className="group flex flex-col">
                    <div className="aspect-[3/4] overflow-hidden rounded-sm bg-neutral-200 mb-3 relative">
                      <img
                        src={member.photo}
                        alt={member.name}
                        className="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-105 transition-all duration-500 ease-out"
                      />
                    </div>
                    <h4 className="font-serif text-base text-black font-medium group-hover:underline">
                      {member.name}
                    </h4>
                    <p className="text-xs text-black/60 font-mono mt-0.5">
                      {member.role}
                    </p>
                  </div>
                ))}
          </div>
        </div>
      </section>

      {/* 8. CONTACT & COMMISSION SECTION */}
      <Contact />
    </div>
  );
};

export default About;
