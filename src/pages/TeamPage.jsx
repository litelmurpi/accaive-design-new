import React from "react";
import { Link } from "react-router-dom";
import Team from "../components/Team";
import Contact from "../components/Contact";
import { useSettings } from "../hooks/useSecondary";

const TeamPage = () => {
  const { settings } = useSettings();

  const teamPageTitle = settings?.team_page_title || "Our Team";
  const teamPageSubtitle =
    settings?.team_page_subtitle || "The minds and makers behind Accaive.";
  const teamJoinTitle = settings?.team_join_title || "Join the Collective";
  const teamJoinDescription =
    settings?.team_join_description ||
    "We are always looking for visionary talent to join our multidisciplinary team.";
  const teamJoinButtonText = settings?.team_join_button_text || "View Openings";

  return (
    <div className="pt-32">
      <div className="px-6 md:px-12 mb-12">
        <h1 className="font-serif text-5xl md:text-7xl lg:text-8xl leading-tight mb-8 text-black">
          {teamPageTitle}
        </h1>
        <p className="text-xl text-gray-600 max-w-2xl">
          {teamPageSubtitle}
        </p>
      </div>
      <Team />

      <div className="px-6 md:px-12 py-20 bg-gray-50 flex flex-col items-center text-center">
        <h3 className="font-serif text-4xl mb-6 text-gray-900">
          {teamJoinTitle}
        </h3>
        <p className="text-gray-600 max-w-xl mb-8">
          {teamJoinDescription}
        </p>
        <Link
          to="/careers"
          className="px-8 py-3 bg-black text-white rounded-full hover:bg-gray-800 transition-colors"
        >
          {teamJoinButtonText}
        </Link>
      </div>

      <Contact />
    </div>
  );
};

export default TeamPage;
