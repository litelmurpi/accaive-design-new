import React, { useRef } from "react";
import { Link } from "react-router-dom";
import ProjectCard from "./ProjectCard";
import { useProjects } from "../hooks/useProjects";
import { useSettings } from "../hooks/useSecondary";
import gsap from "gsap";
import { useGSAP } from "@gsap/react";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

const WorkGrid = () => {
  const { projects, loading } = useProjects(true); // featured = true
  const { settings } = useSettings();
  const sectionRef = useRef(null);

  const projectsHeading = settings?.home_projects_heading || "Our Projects";
  const projectsSubheading = settings?.home_projects_subheading || "We design structures so compelling, their impact is inevitable.";
  const projectsButtonText = settings?.home_projects_button_text || "View All Projects";
  const layout = settings?.home_projects_layout || "asymmetric";

  const getCardSpan = (proj) => {
    if (layout === "grid2") return "md:col-span-6";
    if (layout === "grid3") return "md:col-span-4";
    return proj.span || "md:col-span-6";
  };

  const getCardSize = (proj) => {
    if (layout === "grid2") return "large";
    if (layout === "grid3") return "small";
    return proj.size || "small";
  };

  useGSAP(
    () => {
      if (!loading && projects.length > 0) {
        gsap.from(".project-card", {
          y: 40,
          opacity: 0,
          duration: 0.7,
          stagger: 0.08,
          ease: "power2.out",
          scrollTrigger: {
            trigger: sectionRef.current,
            start: "top 80%",
            once: true,
          },
        });
      }
    },
    { dependencies: [loading, projects, layout], scope: sectionRef },
  );

  if (loading) {
    return (
      <section className="py-24 px-4 md:px-12 min-h-screen flex items-center justify-center">
        <p className="text-2xl font-serif animate-pulse tracking-widest uppercase">Curating Projects...</p>
      </section>
    );
  }

  return (
    <section ref={sectionRef} className="py-24 px-4 md:px-12 overflow-hidden">
      <div className="mb-16 flex flex-col md:flex-row md:items-end justify-between gap-8">
        <div>
          <h2 className="font-serif text-5xl md:text-8xl mb-6">{projectsHeading}</h2>
          <p className="text-xl font-light opacity-70 max-w-xl">
            {projectsSubheading}
          </p>
        </div>
        <Link
          to="/case-studies"
          className="inline-block px-8 py-3 border border-current rounded-full hover:bg-white hover:text-black transition-all duration-300 font-medium h-fit mb-2"
        >
          {projectsButtonText}
        </Link>
      </div>

      <div className="grid grid-cols-1 md:grid-cols-12 gap-6">
        {projects.map((proj) => (
          <div key={proj.slug} className={getCardSpan(proj)}>
            <ProjectCard 
                title={proj.title}
                slug={proj.slug}
                category={proj.category}
                img={proj.hero_image}
                size={getCardSize(proj)}
            />
          </div>
        ))}
      </div>
    </section>
  );
};

export default WorkGrid;

