import React from "react";
import { Link } from "react-router-dom";
import ProjectCard from "./ProjectCard";
import { useProjects } from "../hooks/useProjects";

const WorkGrid = () => {
  const { projects, loading } = useProjects(true); // featured = true

  if (loading) {
    return (
      <section className="bg-[#111] text-white py-24 px-4 md:px-12 min-h-screen flex items-center justify-center">
        <p className="text-2xl font-serif animate-pulse tracking-widest uppercase">Curating Projects...</p>
      </section>
    );
  }

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
          <div key={proj.slug} className={`${proj.span || 'md:col-span-6'}`}>
            <ProjectCard 
                title={proj.title}
                slug={proj.slug}
                category={proj.category}
                img={proj.hero_image}
                size={proj.size}
                index={idx} 
            />
          </div>
        ))}
      </div>
    </section>
  );
};

export default WorkGrid;
