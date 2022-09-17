/*
 * Main and demo navigation arrays
 *
 * 'to' attribute points to the route name, not the path url
 */

export default {
    main: [
        {
            name: "Dashboard",
            to: "/admin/dashboard",
            icon: "si si-speedometer",
        },
        {
            name: "Soil data",
            to: "/admin/soil_data",
            icon: "si si-layers",
        },
        {
            name: "Groundwater data",
            to: "/admin/groundwater_data",
            icon: "si si-drop",
        },
        // {
        //     name: "Static data",
        //     to: "/admin/static_data",
        //     icon: "si si-flag",
        // },
        // {
        //     name: "Page Packs",
        //     icon: "si si-layers",
        //     subActivePaths: "/backend/page-packs",
        //     sub: [
        //         {
        //             name: "Blog",
        //             icon: "si si-pencil",
        //             subActivePaths: "/backend/page-packs/blog",
        //         },
        //     ],
        // },
    ],
};
