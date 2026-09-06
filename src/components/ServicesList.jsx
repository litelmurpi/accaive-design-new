import React, { useState } from "react";
import { Link } from "react-router-dom";
import { ArrowRight } from "lucide-react";
import { useServices } from "../hooks/useServices";
import { useSettings } from "../hooks/useSecondary";
import Skeleton from "./Skeleton";

import { getCategoryForService } from "../utils/categoryMapping";

const ServiceItem = ({ service, isActive, onActivate }) => {
  const category = getCategoryForService(service.title);
  const targetUrl = `/case-studies?category=${encodeURIComponent(category)}`;

  return (
    <div
      className={`group py-8 border-b border-current/15 transition-all duration-300 ${isActive ? "pl-4" : ""}`}
      onMouseEnter={onActivate}
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

  const servicesLabel = settings?.home_services_label || "Programs & Services";
  const servicesHeading = settings?.home_services_heading || "Eleven ways we help clients build and command their unique environments.";
  const servicesButtonText = settings?.home_services_button_text || "Explore Programs";
  const servicesButtonUrl = settings?.home_services_button_url || "/programs";
  const layout = settings?.home_services_layout || "split";

  return (
    <section className="py-24 px-6 md:px-12 transition-colors duration-500">
      <div className={layout === "stacked" ? "flex flex-col gap-12" : "grid grid-cols-1 lg:grid-cols-12 gap-12"}>
        <div className={layout === "stacked" ? "max-w-3xl mb-4" : "lg:col-span-4"}>
          <h2 className="text-xs uppercase tracking-widest opacity-50 mb-8">
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

        <div className={layout === "stacked" ? "w-full" : "lg:col-span-8"}>
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
