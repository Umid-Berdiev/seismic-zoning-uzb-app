/*
 * Main and demo navigation arrays
 *
 * 'to' attribute points to the route name, not the path url
 */

export default {
    main: [
        {
            name: "Map",
            to: "/admin/map",
            icon: "si si-map",
        },
        {
            name: "Statics",
            to: "/admin/statics",
            icon: "si si-flag",
        },
        {
            name: "Users",
            to: "/admin/users",
            icon: "si si-users",
        },
        // {
        //     name: "Roles",
        //     to: "/admin/directory/roles",
        //     icon: "si si-shield",
        // },
        {
            name: "Regions",
            icon: "si si-globe",
            to: "/admin/directory/regions",
        },
        {
            name: "DsrSections",
            icon: "si si-layers",
            to: "/admin/directory/dsr-sections",
        },
        // {
        //     name: "Directory",
        //     // to: "/admin/directory",
        //     subActivePaths: "/admin/directory",
        //     icon: "si si-list",
        //     sub: [
        //         {
        //             name: "Roles",
        //             // icon: "si si-pencil",
        //             to: "/admin/directory/roles",
        //         },
        //         {
        //             name: "Regions",
        //             // icon: "si si-pencil",
        //             to: "/admin/directory/regions",
        //         },
        //         {
        //             name: "DsrSections",
        //             // icon: "si si-pencil",
        //             to: "/admin/directory/dsr-sections",
        //         },
        //     ],
        // },
    ],
};
