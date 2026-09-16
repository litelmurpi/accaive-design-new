import { useState, useEffect } from "react";
import { fetchApi } from "../lib/api";
import { getFallbackProjects, getFallbackProject } from "../data/fallbackData";

export const useProjects = (featured = false) => {
  const [projects, setProjects] = useState(() => getFallbackProjects(featured));
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    const fetchProjects = async () => {
      try {
        setLoading(true);
        const endpoint = featured ? "/projects?featured=1" : "/projects";
        const data = await fetchApi(endpoint);
        if (Array.isArray(data) && data.length > 0) {
          setProjects(data);
        } else {
          setProjects(getFallbackProjects(featured));
        }
        setError(null);
      } catch (err) {
        console.warn("API unavailable, using offline fallback projects:", err.message);
        setProjects(getFallbackProjects(featured));
        setError(err.message);
      } finally {
        setLoading(false);
      }
    };

    fetchProjects();
  }, [featured]);

  return { projects, loading, error };
};

export const useProject = (slug) => {
  const [project, setProject] = useState(() => getFallbackProject(slug));
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    if (!slug) return;

    const fetchProject = async () => {
      try {
        setLoading(true);
        const data = await fetchApi(`/projects/${slug}`);
        if (data && data.title) {
          setProject(data);
        } else {
          setProject(getFallbackProject(slug));
        }
        setError(null);
      } catch (err) {
        console.warn(`API unavailable, using offline fallback for project ${slug}:`, err.message);
        setProject(getFallbackProject(slug));
        setError(err.message);
      } finally {
        setLoading(false);
      }
    };

    fetchProject();
  }, [slug]);

  return { project, loading, error };
};
