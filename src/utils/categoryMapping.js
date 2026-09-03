/**
 * Mapping between service titles and architectural project categories.
 */
export const serviceCategoryMap = {
  "Adaptive Reuse": "Cultural",
  "Urban Planning": "Public",
  "Interior Ecosystems": "Residential",
  "Brand Architecture": "Commercial",
  "Design bla bla bla": "Workplace",
};

export const getCategoryForService = (serviceTitle) => {
  if (!serviceTitle) return "All";
  return serviceCategoryMap[serviceTitle] || "All";
};
