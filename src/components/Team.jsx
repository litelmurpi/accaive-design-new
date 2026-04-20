import React from "react";
import TeamMember from "./TeamMember";
import { useTeam } from "../hooks/useTeam";
import Skeleton from "./Skeleton";

const Team = () => {
  const { team: members, loading } = useTeam();

  return (
    <section className="py-24 px-6 md:px-12 bg-white">
      <div className="flex flex-col md:flex-row justify-between items-end mb-16">
        <div>
          <span className="text-xs uppercase tracking-widest text-gray-500 mb-2 block">
            Team
          </span>
          <h2 className="font-serif text-5xl md:text-6xl text-gray-900">
            Meet the makers.
          </h2>
        </div>
        <p className="md:w-1/3 text-gray-600 mt-6 md:mt-0 leading-relaxed">
          We asked our team to choose a piece of architecture that represents
          them. From brutalist monuments to sustainable dwellings. Different
          backgrounds, same high standards.
        </p>
      </div>

      <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 md:gap-8">
        {loading
          ? Array(6)
              .fill(0)
              .map((_, idx) => (
                <div key={idx} className="space-y-4">
                  <Skeleton className="w-full aspect-[3/4]" />
                  <Skeleton className="w-3/4 h-4" />
                  <Skeleton className="w-1/2 h-3" />
                </div>
              ))
          : members.map((member, idx) => (
              <TeamMember
                key={member.id || idx}
                {...member}
                img={member.photo}
              />
            ))}
      </div>
    </section>
  );
};

export default Team;
