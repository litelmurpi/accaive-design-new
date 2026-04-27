import React from "react";
import { Link } from "react-router-dom";
import { useSettings } from "../hooks/useSecondary";

const Footer = () => {
  const { settings } = useSettings();
  const siteTitle = settings?.site_title || "Accaive Design Studio";
  const brandName = siteTitle.split(" ")[0].toUpperCase();

  return (
    <footer className="bg-[#1a0f0a] text-white py-20 px-6 md:px-12">
    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 border-b border-white/20 pb-16">
      <div className="col-span-1 lg:col-span-2">
        <h2 className="text-3xl font-bold tracking-widest mb-6">{brandName}</h2>
        <div className="max-w-md">
          <h3 className="text-xl font-serif mb-4">Keep up to date</h3>
          <div className="flex border-b border-white/30 pb-2">
            <input
              type="email"
              placeholder="Your email"
              className="bg-transparent border-none outline-none w-full placeholder-white/50"
            />
            <button className="uppercase text-xs font-bold tracking-widest">
              Submit
            </button>
          </div>
        </div>
      </div>

      <div>
        <h4 className="text-xs uppercase tracking-widest text-white/50 mb-6">
          Studio
        </h4>
        <ul className="space-y-3 text-sm font-light">
          <li>
            <Link to="/contact" className="hover:text-white/70">
              Work with us
            </Link>
          </li>
          <li>
            <Link to="/team" className="hover:text-white/70">
              Team
            </Link>
          </li>
          <li>
            <Link to="/careers" className="hover:text-white/70">
              Careers
            </Link>
          </li>
          <li>
            <Link to="/press" className="hover:text-white/70">
              Press
            </Link>
          </li>
        </ul>
      </div>

      <div>
        <h4 className="text-xs uppercase tracking-widest text-white/50 mb-6">
          Social
        </h4>
        <ul className="space-y-3 text-sm font-light">
          <li>
            <a
              href="https://instagram.com"
              target="_blank"
              rel="noopener noreferrer"
              className="hover:text-white/70"
            >
              Instagram
            </a>
          </li>
          <li>
            <a
              href="https://linkedin.com"
              target="_blank"
              rel="noopener noreferrer"
              className="hover:text-white/70"
            >
              LinkedIn
            </a>
          </li>
          <li>
            <a
              href="https://twitter.com"
              target="_blank"
              rel="noopener noreferrer"
              className="hover:text-white/70"
            >
              Twitter
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div className="pt-8 flex flex-col md:flex-row justify-between text-xs text-white/40">
      <p>&copy; {new Date().getFullYear()} {siteTitle}. All rights reserved.</p>
      <div className="flex gap-6 mt-4 md:mt-0">
        <a href="#">Privacy Policy</a>
        <a href="#">Terms of Use</a>
      </div>
    </div>
  </footer>
  );
};

export default Footer;
