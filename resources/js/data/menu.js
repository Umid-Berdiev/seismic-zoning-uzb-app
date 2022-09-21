/*
 * Main and demo navigation arrays
 *
 * 'to' attribute points to the route name, not the path url
 */

export default {
    main: [
        {
            name: "Statistics",
            to: "/admin/dashboard",
            icon: "si si-speedometer",
        },
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
        {
            name: "Directory",
            // to: "/admin/directory",
            subActivePaths: "/admin/directory",
            icon: "si si-list",
            sub: [
                {
                    name: "Roles",
                    // icon: "si si-pencil",
                    to: "/admin/directory/roles",
                },
            ],
        },
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
