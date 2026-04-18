import React from "react";
import { Link } from "react-router-dom";
import ProjectCard from "./ProjectCard";

const WorkGrid = () => {
  const projects = [
    {
      title: "The Void House",
      slug: "the-void-house",
      category: "Residential",
      img: "https://images.unsplash.com/photo-1600607686527-6fb886090705?q=80&w=2727&auto=format&fit=crop",
      size: "large",
      span: "md:col-span-7",
    },
    {
      title: "Nebula Tower",
      slug: "nebula-tower",
      category: "Commercial",
      img: "https://images.unsplash.com/photo-1486718448742-163732cd1544?q=80&w=2600&auto=format&fit=crop",
      size: "small",
      span: "md:col-span-5",
    },
    {
      title: "Silence Pavilion",
      slug: "silence-pavilion",
      category: "Cultural",
      img: "https://images.unsplash.com/photo-1628744448840-55bdb2497bd4?q=80&w=2670&auto=format&fit=crop",
      size: "tall",
      span: "md:col-span-4",
    },
    {
      title: "Echo Library",
      slug: "echo-library",
      category: "Public",
      img: "https://images.unsplash.com/photo-1544984243-ec57ea16fe25?q=80&w=2574&auto=format&fit=crop",
      size: "wide",
      span: "md:col-span-8",
    },
    {
      title: "Horizon Villa",
      slug: "horizon-villa",
      category: "Residential",
      img: "https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=2670&auto=format&fit=crop",
      size: "large",
      span: "md:col-span-6",
    },
    {
      title: "Apex HQ",
      slug: "apex-hq",
      category: "Workplace",
      img: "https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=2669&auto=format&fit=crop",
      size: "small",
      span: "md:col-span-6",
    },
  ];

  return (
    <section className="bg-[#111] text-white py-24 px-4 md:px-12 overflow-hidden">
      <div className="mb-16 flex flex-col md:flex-row md:items-end justify-between gap-8">
        <div>
          <h2 className="font-serif text-5xl md:text-8xl mb-6">Our Projects</h2>
          <p className="text-xl font-light text-gray-400 max-w-xl">
            We design structures so compelling, their impact is inevitable.
          </p>
        </div>
        <Link
          to="/case-studies"
          className="inline-block px-8 py-3 border border-white/20 rounded-full hover:bg-white hover:text-black transition-all duration-300 font-medium h-fit mb-2"
        >
          View All Projects
        </Link>
      </div>

      <div className="grid grid-cols-1 md:grid-cols-12 gap-6">
        {projects.map((proj, idx) => (
          <div key={proj.slug} className={`${proj.span}`}>
            <ProjectCard {...proj} index={idx} />
          </div>
        ))}
      </div>
    </section>
  );
};

export default WorkGrid;
