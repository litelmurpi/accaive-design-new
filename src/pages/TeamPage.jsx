import React from "react";
import { Link } from "react-router-dom";
import Team from "../components/Team";
import Contact from "../components/Contact";

const TeamPage = () => {
  return (
    <div className="pt-32">
      <div className="px-6 md:px-12 mb-12">
        <h1 className="font-serif text-5xl md:text-7xl lg:text-8xl leading-tight mb-8 text-black">
          Our Team
        </h1>
        <p className="text-xl text-gray-600 max-w-2xl">
          The minds and makers behind Accaive.
        </p>
      </div>
      <Team />

      <div className="px-6 md:px-12 py-20 bg-gray-50 flex flex-col items-center text-center">
        <h3 className="font-serif text-4xl mb-6 text-gray-900">
          Join the Collective
        </h3>
        <p className="text-gray-600 max-w-xl mb-8">
          We are always looking for visionary talent to join our
          multidisciplinary team.
        </p>
        <Link
          to="/careers"
          className="px-8 py-3 bg-black text-white rounded-full hover:bg-gray-800 transition-colors"
        >
          View Openings
        </Link>
      </div>

      <Contact />
    </div>
  );
};

export default TeamPage;
