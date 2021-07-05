export default {
 menu: [
  {
   text: "",
   key: "",
   items: [{ icon: "mdi-view-dashboard-outline", key: "menu.dashboard", text: "Dashboard", link: "/dashboard/analytics" }]
  },
  {
   text: "Other",
   items: [
    { icon: "mdi-file-outline", text: "Blank Page", link: "/blank" },
    {
     text: "Products",
     icon: "mdi-file-outline",
     items: [
      { icon: "mdi-file-outline", text: "Child  2.1" },
      {
       icon: "mdi-file-outline",
       text: "Sub-Child 2.2 ",
       items: [
        { icon: "mdi-file-outline", text: "Menu Levels 3.1" },
        { icon: "mdi-file-outline", text: "Menu Levels 3.2" }
       ]
      }
     ]
    }
   ]
  }
 ],

 // footer links
 footer: [
  {
   text: "Docs",
   key: "menu.docs",
   href: "https://vuetifyjs.com",
   target: "_blank"
  }
 ]
};
