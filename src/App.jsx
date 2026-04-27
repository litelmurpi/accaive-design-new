import React, { useState, useEffect } from "react";
import { Routes, Route, useLocation } from "react-router-dom";
import Lenis from "lenis";
import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import Navbar from "./components/Navbar";
import MenuOverlay from "./components/MenuOverlay";
import Footer from "./components/Footer";
import Preloader from "./components/Preloader";
import CustomCursor from "./components/CustomCursor";
import PageTransition from "./components/PageTransition";
import { ThemeProvider } from "./context/ThemeContext";
import { useTheme } from "./context/useTheme";
import { useSettings } from "./hooks/useSecondary";

// Pages
import Home from "./pages/Home";
import CaseStudies from "./pages/CaseStudies";
import Programs from "./pages/Programs";
import ArtsCulture from "./pages/ArtsCulture";
import TeamPage from "./pages/TeamPage";
import Careers from "./pages/Careers";
import Press from "./pages/Press";
import ContactForm from "./pages/ContactForm";
import NotFound from "./pages/NotFound";
import ProjectDetail from "./pages/ProjectDetail";

function AppContent() {
  const [isMenuOpen, setIsMenuOpen] = useState(false);
  const [isLoading, setIsLoading] = useState(true);
  const location = useLocation();
  const { isDarkMode } = useTheme();
  const { settings } = useSettings();

  const toggleMenu = () => setIsMenuOpen(!isMenuOpen);

  // Update document title based on site_title setting
  useEffect(() => {
    if (settings?.site_title) {
      document.title = settings.site_title;
    }
  }, [settings]);

  // Initialize Lenis and sync with GSAP
  useEffect(() => {
    const lenis = new Lenis({
      duration: 1.2,
      easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
      smoothWheel: true,
    });

    // Sync ScrollTrigger with Lenis
    lenis.on("scroll", ScrollTrigger.update);

    // Add Lenis to GSAP Ticker
    gsap.ticker.add((time) => {
      lenis.raf(time * 1000);
    });

    // Disable GSAP lag smoothing for better sync
    gsap.ticker.lagSmoothing(0);

    return () => {
      lenis.destroy();
      gsap.ticker.remove(lenis.raf);
    };
  }, []);

  // Lock body scroll when menu is open
  useEffect(() => {
    if (isMenuOpen) {
      document.body.style.overflow = "hidden";
    } else {
      document.body.style.overflow = "unset";
    }
  }, [isMenuOpen]);

  // Scroll to top on route change
  useEffect(() => {
    window.scrollTo(0, 0);
  }, [location]);

  return (
    <div
      className={`relative font-sans theme-wrapper custom-cursor-active ${
        isDarkMode ? "theme-dark" : "theme-light"
      }`}
    >
      <CustomCursor />
      {isLoading && <Preloader onComplete={() => setIsLoading(false)} />}

      <Navbar toggleMenu={toggleMenu} isMenuOpen={isMenuOpen} />
      <MenuOverlay isOpen={isMenuOpen} toggleMenu={toggleMenu} />

      <main>
        <PageTransition>
          <Routes>
            <Route path="/" element={<Home />} />
            <Route path="/case-studies" element={<CaseStudies />} />
            <Route path="/programs" element={<Programs />} />
            <Route path="/arts-culture" element={<ArtsCulture />} />
            <Route path="/team" element={<TeamPage />} />
            <Route path="/careers" element={<Careers />} />
            <Route path="/press" element={<Press />} />
            <Route path="/contact" element={<ContactForm />} />
            <Route path="/project/:slug" element={<ProjectDetail />} />
            <Route path="*" element={<NotFound />} />
          </Routes>
        </PageTransition>
      </main>

      <Footer />
    </div>
  );
}

function App() {
  return (
    <ThemeProvider>
      <AppContent />
    </ThemeProvider>
  );
}

export default App;
