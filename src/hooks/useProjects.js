import { useState, useEffect } from "react";
import { fetchApi } from "../lib/api";

export const useProjects = (featured = false) => {
  const [projects, setProjects] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    const fetchProjects = async () => {
      try {
        setLoading(true);
        const endpoint = featured ? "/projects?featured=1" : "/projects";
        const data = await fetchApi(endpoint);
        setProjects(data);
        setError(null);
      } catch (err) {
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
  const [project, setProject] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    if (!slug) return;

    const fetchProject = async () => {
      try {
        setLoading(true);
        const data = await fetchApi(`/projects/${slug}`);
        setProject(data);
        setError(null);
      } catch (err) {
        setError(err.message);
      } finally {
        setLoading(false);
      }
    };

    fetchProject();
  }, [slug]);

  return { project, loading, error };
};
