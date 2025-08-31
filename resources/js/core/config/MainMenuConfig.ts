export interface MenuItem {
  heading?: string;
  sectionTitle?: string;
  route?: string;
  pages?: Array<MenuItem>;
  keenthemesIcon?: string;
  bootstrapIcon?: string;
  sub?: Array<MenuItem>;
}

const MainMenuConfig: Array<MenuItem> = [

  {
    pages: [
      {
        heading: "dashboard",
        route: "/dashboard",
        keenthemesIcon: "element-11",
        bootstrapIcon: "bi-app-indicator",
      },
      {
        heading:"Inventory",
        route:'/inventory',
        keenthemesIcon: "cube-3",
      },
      {
        heading:"Products",
        route:'/product',
        keenthemesIcon: "cube-2",
      },
      {
        heading:"Ask AI",
        route:'/ask-ai',
        keenthemesIcon: "user-tick",
      },
    
    ],
  },
];

export default MainMenuConfig;
