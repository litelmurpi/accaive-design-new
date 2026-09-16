import React, { useState } from "react";
import { Link } from "react-router-dom";
import { ArrowRight } from "lucide-react";
import { useServices } from "../hooks/useServices";
import { useSettings } from "../hooks/useSecondary";
import Skeleton from "./Skeleton";
import { getCategoryForService } from "../utils/categoryMapping";

// Curated default architectural photography for each service
const DEFAULT_SERVICE_IMAGES = [
  "https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=1600&auto=format&fit=crop", // 01 Spatial Strategy
  "https://images.unsplash.com/photo-1513694203232-719a280e022f?q=80&w=1600&auto=format&fit=crop", // 02 Adaptive Reuse
  "https://images.unsplash.com/photo-1577495508048-b635879837f1?q=80&w=1600&auto=format&fit=crop", // 03 Urban Planning
  "https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?q=80&w=1600&auto=format&fit=crop", // 04 Interior Ecosystems
  "https://images.unsplash.com/photo-1600607686527-6fb886090705?q=80&w=1600&auto=format&fit=crop", // 05 Brand Architecture
];

const ServiceItem = ({ service, isActive, onActivate }) => {
  const category = getCategoryForService(service.title);
  const targetUrl = `/case-studies?category=${encodeURIComponent(category)}`;

  return (
    <div
      className={`group py-8 border-b border-current/15 transition-all duration-300 ${isActive ? "pl-4" : ""}`}
      onMouseEnter={onActivate}
      onFocus={onActivate}
    >
      <Link
        to={targetUrl}
        className="flex justify-between items-center cursor-pointer"
      >
        <h3
          className={`text-2xl md:text-4xl font-serif transition-colors duration-300 ${isActive ? "text-current" : "opacity-40 group-hover:opacity-75"}`}
        >
          {service.title}
        </h3>
        <span
          className={`text-sm transition-all duration-300 ${isActive ? "opacity-100 translate-x-0" : "opacity-0 -translate-x-2"}`}
        >
          <ArrowRight size={20} />
        </span>
      </Link>
      <div className={`accordion-grid ${isActive ? "is-open" : ""}`}>
        <div className="accordion-inner">
          <p className="opacity-70 text-lg font-light max-w-lg pt-4 pb-3">
            {service.desc}
          </p>
          <Link
            to={targetUrl}
            className="inline-flex items-center gap-2 text-xs uppercase tracking-widest font-semibold opacity-90 hover:opacity-100 underline underline-offset-4 transition-opacity"
          >
            <span>View {category} Projects</span>
            <ArrowRight size={14} />
          </Link>
        </div>
      </div>
    </div>
  );
};

const ServicesList = () => {
  const { services, loading } = useServices();
  const { settings } = useSettings();
  const [activeService, setActiveService] = useState(0);

  const servicesLabel = settings?.home_services_label || "About Us";
  const servicesHeading = settings?.home_services_heading || "Architecture, archived. Stories, remembered.";
  const servicesButtonText = settings?.home_services_button_text || "[Why Us?]";
  const servicesButtonUrl = settings?.home_services_button_url || "/about";
  const layout = settings?.home_services_layout || "split";

  return (
    <section className="py-24 px-6 md:px-12 transition-colors duration-500">
      <div className={layout === "stacked" ? "flex flex-col gap-12" : "grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start"}>
        {/* Left Column: Heading, Button & Dynamic Hover Image Preview */}
        <div className={layout === "stacked" ? "max-w-3xl mb-4" : "lg:col-span-5 lg:sticky lg:top-28 self-start space-y-8"}>
          <div>
            <h2 className="text-xs uppercase tracking-widest opacity-50 mb-6 font-mono">
              {servicesLabel}
            </h2>
            <p className="font-serif text-3xl md:text-4xl leading-tight mb-8">
              {servicesHeading}
            </p>
            <Link
              to={servicesButtonUrl}
              className="inline-block px-6 py-3 border border-current bg-black text-white dark:bg-white dark:text-black rounded-full transition-all text-sm font-medium hover:scale-105 hover:shadow-lg"
            >
              {servicesButtonText}
            </Link>
          </div>

          {/* Dynamic Architectural Image Preview Display */}
          <div className="pt-2">
            {loading ? (
              <Skeleton className="w-full aspect-[4/3] md:aspect-[16/11] rounded-sm" />
            ) : (
              <div className="relative w-full aspect-[4/3] md:aspect-[16/11] rounded-sm overflow-hidden bg-neutral-100 dark:bg-neutral-900 border border-black/5 dark:border-white/10 shadow-2xl">
                {services.map((service, idx) => {
                  const isCurrent = activeService === idx;
                  const imgUrl =
                    service.image ||
                    service.image_url ||
                    DEFAULT_SERVICE_IMAGES[idx % DEFAULT_SERVICE_IMAGES.length];

                  return (
                    <div
                      key={service.id || idx}
                      className={`absolute inset-0 transition-all duration-700 ease-out ${
                        isCurrent
                          ? "opacity-100 scale-100 pointer-events-auto"
                          : "opacity-0 scale-105 pointer-events-none"
                      }`}
                    >
                      <img
                        src={imgUrl}
                        alt={service.title}
                        loading="lazy"
                        onError={(e) => {
                          e.currentTarget.src = DEFAULT_SERVICE_IMAGES[0];
                        }}
                        className="w-full h-full object-cover filter contrast-[1.03]"
                      />
                      {/* Vignette shadow gradient for legibility */}
                      <div className="absolute inset-0 bg-gradient-to-t from-black/75 via-black/10 to-transparent pointer-events-none" />

                      {/* Studio Metadata Badge */}
                      <div className="absolute bottom-3.5 left-3.5 flex items-center gap-2.5 bg-black/65 backdrop-blur-md px-3.5 py-1.5 rounded-sm border border-white/15 text-white text-[11px] font-mono uppercase tracking-widest pointer-events-none shadow-sm">
                        <span className="relative flex h-2 w-2">
                          <span className="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                          <span className="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                        <span className="font-medium">
                          {service.code ? `${service.code} / ` : ""}
                          {service.title}
                        </span>
                      </div>
                    </div>
                  );
                })}
              </div>
            )}
          </div>
        </div>

        {/* Right Column: Interactive Services Accordion List */}
        <div className={layout === "stacked" ? "w-full" : "lg:col-span-7"}>
          <div className="flex flex-col">
            {loading ? (
              <div className="space-y-4">
                <Skeleton className="w-full h-24" />
                <Skeleton className="w-full h-24" />
                <Skeleton className="w-full h-24" />
              </div>
            ) : (
              services.map((service, index) => (
                <ServiceItem
                  key={service.id}
                  service={{ ...service, desc: service.description }}
                  isActive={activeService === index}
                  onActivate={() => setActiveService(index)}
                />
              ))
            )}
          </div>
        </div>
      </div>
    </section>
  );
};

export default ServicesList;
