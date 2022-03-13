const Ziggy = {
    url: "http://localhost",
    port: null,
    defaults: {},
    routes: {
        "auth.loginUser": { uri: "auth/login", methods: ["POST"] },
        "auth.login": { uri: "auth/login", methods: ["GET", "HEAD"] },
        "auth.logout": { uri: "auth/logout", methods: ["GET", "HEAD"] },
        "objective.index": { uri: "objective", methods: ["GET", "HEAD"] },
        "objective.store": { uri: "objective/add", methods: ["POST"] },
        "objective.update": { uri: "objective/update", methods: ["PUT"] },
        "objective.delete": { uri: "objective/delete", methods: ["DELETE"] },
        "product.index": { uri: "product", methods: ["GET", "HEAD"] },
        "product.create": { uri: "product/add", methods: ["GET", "HEAD"] },
        "product.store": { uri: "product/add", methods: ["POST"] },
        "product.edit": { uri: "product/edit/{id}", methods: ["GET", "HEAD"] },
        "product.update": { uri: "product/update", methods: ["POST"] },
        "product.delete": { uri: "product/delete/{id}", methods: ["DELETE"] },
        "product.imageDestroy": { uri: "product/delete", methods: ["POST"] },
        "user.list": { uri: "user/list", methods: ["GET", "HEAD"] },
        "user.store": { uri: "user/add", methods: ["POST"] },
        "user.index": { uri: "user", methods: ["GET", "HEAD"] },
        "user.update": { uri: "user/update", methods: ["PUT"] },
        "user.delete": { uri: "user/delete", methods: ["DELETE"] },
        "roles.index": { uri: "roles", methods: ["GET", "HEAD"] },
        "roles.detail": {
            uri: "roles/{id}",
            methods: ["GET", "HEAD"],
            wheres: { id: "[0-9]+" },
        },
        "roles.store": { uri: "roles", methods: ["POST"] },
        "roles.update": {
            uri: "roles/{id}",
            methods: ["POST"],
            wheres: { id: "[0-9]+" },
        },
        "roles.delete": {
            uri: "roles/{id}",
            methods: ["DELETE"],
            wheres: { id: "[0-9]+" },
        },
        "company.index": { uri: "company", methods: ["GET", "HEAD"] },
        "company.company": { uri: "company/company", methods: ["GET", "HEAD"] },
        "company.create": { uri: "company/add", methods: ["GET", "HEAD"] },
        "company.delete": {
            uri: "company/{id}",
            methods: ["DELETE"],
            wheres: { id: "[0-9]+" },
        },
        "company.store": { uri: "company", methods: ["POST"] },
        "dashboard-ecommerce": {
            uri: "dashboard/ecommerce",
            methods: ["GET", "HEAD"],
        },
        "dashboard-analytics": {
            uri: "dashboard/analytics",
            methods: ["GET", "HEAD"],
        },
        "app-email": { uri: "app/email", methods: ["GET", "HEAD"] },
        "app-chat": { uri: "app/chat", methods: ["GET", "HEAD"] },
        "app-todo": { uri: "app/todo", methods: ["GET", "HEAD"] },
        "app-calendar": { uri: "app/calendar", methods: ["GET", "HEAD"] },
        "app-kanban": { uri: "app/kanban", methods: ["GET", "HEAD"] },
        "app-invoice-list": {
            uri: "app/invoice/list",
            methods: ["GET", "HEAD"],
        },
        "app-invoice-preview": {
            uri: "app/invoice/preview",
            methods: ["GET", "HEAD"],
        },
        "app-invoice-edit": {
            uri: "app/invoice/edit",
            methods: ["GET", "HEAD"],
        },
        "app-invoice-add": { uri: "app/invoice/add", methods: ["GET", "HEAD"] },
        "app-invoice-print": {
            uri: "app/invoice/print",
            methods: ["GET", "HEAD"],
        },
        "app-ecommerce-shop": {
            uri: "app/ecommerce/shop",
            methods: ["GET", "HEAD"],
        },
        "app-ecommerce-details": {
            uri: "app/ecommerce/details",
            methods: ["GET", "HEAD"],
        },
        "app-ecommerce-wishlist": {
            uri: "app/ecommerce/wishlist",
            methods: ["GET", "HEAD"],
        },
        "app-ecommerce-checkout": {
            uri: "app/ecommerce/checkout",
            methods: ["GET", "HEAD"],
        },
        "app-file-manager": {
            uri: "app/file-manager",
            methods: ["GET", "HEAD"],
        },
        "app-access-roles": {
            uri: "app/access-roles",
            methods: ["GET", "HEAD"],
        },
        "app-access-permission": {
            uri: "app/access-permission",
            methods: ["GET", "HEAD"],
        },
        "app-user-list": { uri: "app/user/list", methods: ["GET", "HEAD"] },
        "app-user-view-account": {
            uri: "app/user/view/account",
            methods: ["GET", "HEAD"],
        },
        "app-user-view-security": {
            uri: "app/user/view/security",
            methods: ["GET", "HEAD"],
        },
        "app-user-view-billing": {
            uri: "app/user/view/billing",
            methods: ["GET", "HEAD"],
        },
        "app-user-view-notifications": {
            uri: "app/user/view/notifications",
            methods: ["GET", "HEAD"],
        },
        "app-user-view-connections": {
            uri: "app/user/view/connections",
            methods: ["GET", "HEAD"],
        },
        "ui-typography": { uri: "ui/typography", methods: ["GET", "HEAD"] },
        "icons-feather": { uri: "icons/feather", methods: ["GET", "HEAD"] },
        "card-basic": { uri: "card/basic", methods: ["GET", "HEAD"] },
        "card-advance": { uri: "card/advance", methods: ["GET", "HEAD"] },
        "card-statistics": { uri: "card/statistics", methods: ["GET", "HEAD"] },
        "card-analytics": { uri: "card/analytics", methods: ["GET", "HEAD"] },
        "card-actions": { uri: "card/actions", methods: ["GET", "HEAD"] },
        "component-accordion": {
            uri: "component/accordion",
            methods: ["GET", "HEAD"],
        },
        "component-alert": { uri: "component/alert", methods: ["GET", "HEAD"] },
        "   -avatar": { uri: "component/avatar", methods: ["GET", "HEAD"] },
        "component-badges": {
            uri: "component/badges",
            methods: ["GET", "HEAD"],
        },
        "component-breadcrumbs": {
            uri: "component/breadcrumbs",
            methods: ["GET", "HEAD"],
        },
        "component-buttons": {
            uri: "component/buttons",
            methods: ["GET", "HEAD"],
        },
        "component-carousel": {
            uri: "component/carousel",
            methods: ["GET", "HEAD"],
        },
        "component-collapse": {
            uri: "component/collapse",
            methods: ["GET", "HEAD"],
        },
        "component-divider": {
            uri: "component/divider",
            methods: ["GET", "HEAD"],
        },
        "component-dropdowns": {
            uri: "component/dropdowns",
            methods: ["GET", "HEAD"],
        },
        "component-list-group": {
            uri: "component/list-group",
            methods: ["GET", "HEAD"],
        },
        "component-modals": {
            uri: "component/modals",
            methods: ["GET", "HEAD"],
        },
        "component-pagination": {
            uri: "component/pagination",
            methods: ["GET", "HEAD"],
        },
        "component-navs": { uri: "component/navs", methods: ["GET", "HEAD"] },
        "component-offcanvas": {
            uri: "component/offcanvas",
            methods: ["GET", "HEAD"],
        },
        "component-tabs": { uri: "component/tabs", methods: ["GET", "HEAD"] },
        "component-timeline": {
            uri: "component/timeline",
            methods: ["GET", "HEAD"],
        },
        "component-pills": { uri: "component/pills", methods: ["GET", "HEAD"] },
        "component-tooltips": {
            uri: "component/tooltips",
            methods: ["GET", "HEAD"],
        },
        "component-popovers": {
            uri: "component/popovers",
            methods: ["GET", "HEAD"],
        },
        "component-pill-badges": {
            uri: "component/pill-badges",
            methods: ["GET", "HEAD"],
        },
        "component-progress": {
            uri: "component/progress",
            methods: ["GET", "HEAD"],
        },
        "component-spinner": {
            uri: "component/spinner",
            methods: ["GET", "HEAD"],
        },
        "component-bs-toast": {
            uri: "component/toast",
            methods: ["GET", "HEAD"],
        },
        "ext-component-sweet-alerts": {
            uri: "ext-component/sweet-alerts",
            methods: ["GET", "HEAD"],
        },
        "ext-component-block-ui": {
            uri: "ext-component/block-ui",
            methods: ["GET", "HEAD"],
        },
        "ext-component-toastr": {
            uri: "ext-component/toastr",
            methods: ["GET", "HEAD"],
        },
        "ext-component-sliders": {
            uri: "ext-component/sliders",
            methods: ["GET", "HEAD"],
        },
        "ext-component-drag-drop": {
            uri: "ext-component/drag-drop",
            methods: ["GET", "HEAD"],
        },
        "ext-component-tour": {
            uri: "ext-component/tour",
            methods: ["GET", "HEAD"],
        },
        "ext-component-clipboard": {
            uri: "ext-component/clipboard",
            methods: ["GET", "HEAD"],
        },
        "ext-component-plyr": {
            uri: "ext-component/plyr",
            methods: ["GET", "HEAD"],
        },
        "ext-component-context-menu": {
            uri: "ext-component/context-menu",
            methods: ["GET", "HEAD"],
        },
        "ext-component-swiper": {
            uri: "ext-component/swiper",
            methods: ["GET", "HEAD"],
        },
        "ext-component-tree": {
            uri: "ext-component/tree",
            methods: ["GET", "HEAD"],
        },
        "ext-component-ratings": {
            uri: "ext-component/ratings",
            methods: ["GET", "HEAD"],
        },
        "ext-component-locale": {
            uri: "ext-component/locale",
            methods: ["GET", "HEAD"],
        },
        "layout-collapsed-menu": {
            uri: "page-layouts/collapsed-menu",
            methods: ["GET", "HEAD"],
        },
        "layout-full": { uri: "page-layouts/full", methods: ["GET", "HEAD"] },
        "layout-without-menu": {
            uri: "page-layouts/without-menu",
            methods: ["GET", "HEAD"],
        },
        "layout-empty": { uri: "page-layouts/empty", methods: ["GET", "HEAD"] },
        "layout-blank": { uri: "page-layouts/blank", methods: ["GET", "HEAD"] },
        "form-input": { uri: "form/input", methods: ["GET", "HEAD"] },
        "form-input-groups": {
            uri: "form/input-groups",
            methods: ["GET", "HEAD"],
        },
        "form-input-mask": { uri: "form/input-mask", methods: ["GET", "HEAD"] },
        "form-textarea": { uri: "form/textarea", methods: ["GET", "HEAD"] },
        "form-checkbox": { uri: "form/checkbox", methods: ["GET", "HEAD"] },
        "form-radio": { uri: "form/radio", methods: ["GET", "HEAD"] },
        "form-custom-options": {
            uri: "form/custom-options",
            methods: ["GET", "HEAD"],
        },
        "form-switch": { uri: "form/switch", methods: ["GET", "HEAD"] },
        "form-select": { uri: "form/select", methods: ["GET", "HEAD"] },
        "form-number-input": {
            uri: "form/number-input",
            methods: ["GET", "HEAD"],
        },
        "form-file-uploader": {
            uri: "form/file-uploader",
            methods: ["GET", "HEAD"],
        },
        "form-quill-editor": {
            uri: "form/quill-editor",
            methods: ["GET", "HEAD"],
        },
        "form-date-time-picker": {
            uri: "form/date-time-picker",
            methods: ["GET", "HEAD"],
        },
        "form-layout": { uri: "form/layout", methods: ["GET", "HEAD"] },
        "form-wizard": { uri: "form/wizard", methods: ["GET", "HEAD"] },
        "form-validation": { uri: "form/validation", methods: ["GET", "HEAD"] },
        "form-repeater": { uri: "form/repeater", methods: ["GET", "HEAD"] },
        table: { uri: "table", methods: ["GET", "HEAD"] },
        "datatable-basic": {
            uri: "table/datatable/basic",
            methods: ["GET", "HEAD"],
        },
        "datatable-advance": {
            uri: "table/datatable/advance",
            methods: ["GET", "HEAD"],
        },
        "page-account-settings-account": {
            uri: "page/account-settings-account",
            methods: ["GET", "HEAD"],
        },
        "page-account-settings-security": {
            uri: "page/account-settings-security",
            methods: ["GET", "HEAD"],
        },
        "page-account-settings-billing": {
            uri: "page/account-settings-billing",
            methods: ["GET", "HEAD"],
        },
        "page-account-settings-notifications": {
            uri: "page/account-settings-notifications",
            methods: ["GET", "HEAD"],
        },
        "page-account-settings-connections": {
            uri: "page/account-settings-connections",
            methods: ["GET", "HEAD"],
        },
        "page-profile": { uri: "page/profile", methods: ["GET", "HEAD"] },
        "page-faq": { uri: "page/faq", methods: ["GET", "HEAD"] },
        "page-knowledge-base": {
            uri: "page/knowledge-base/category/question",
            methods: ["GET", "HEAD"],
        },
        "page-pricing": { uri: "page/pricing", methods: ["GET", "HEAD"] },
        "page-api-key": { uri: "page/api-key", methods: ["GET", "HEAD"] },
        "page-blog-list": { uri: "page/blog/list", methods: ["GET", "HEAD"] },
        "page-blog-detail": {
            uri: "page/blog/detail",
            methods: ["GET", "HEAD"],
        },
        "page-blog-edit": { uri: "page/blog/edit", methods: ["GET", "HEAD"] },
        "misc-coming-soon": {
            uri: "page/coming-soon",
            methods: ["GET", "HEAD"],
        },
        "misc-not-authorized": {
            uri: "page/not-authorized",
            methods: ["GET", "HEAD"],
        },
        "misc-maintenance": {
            uri: "page/maintenance",
            methods: ["GET", "HEAD"],
        },
        "page-license": { uri: "page/license", methods: ["GET", "HEAD"] },
        "modal-examples": { uri: "modal-examples", methods: ["GET", "HEAD"] },
        error: { uri: "error", methods: ["GET", "HEAD"] },
        login: { uri: "authDev/login", methods: ["GET", "HEAD"] },
        logout: { uri: "authDev/logout", methods: ["GET", "HEAD"] },
        "auth-login-basic": {
            uri: "authDev/login-basic",
            methods: ["GET", "HEAD"],
        },
        "auth-login-cover": {
            uri: "authDev/login-cover",
            methods: ["GET", "HEAD"],
        },
        "auth-register-basic": {
            uri: "authDev/register-basic",
            methods: ["GET", "HEAD"],
        },
        "auth-register-cover": {
            uri: "authDev/register-cover",
            methods: ["GET", "HEAD"],
        },
        "auth-forgot-password-basic": {
            uri: "authDev/forgot-password-basic",
            methods: ["GET", "HEAD"],
        },
        "auth-forgot-password-cover": {
            uri: "authDev/forgot-password-cover",
            methods: ["GET", "HEAD"],
        },
        "auth-reset-password-basic": {
            uri: "authDev/reset-password-basic",
            methods: ["GET", "HEAD"],
        },
        "auth-reset-password-cover": {
            uri: "authDev/reset-password-cover",
            methods: ["GET", "HEAD"],
        },
        "auth-verify-email-basic": {
            uri: "authDev/verify-email-basic",
            methods: ["GET", "HEAD"],
        },
        "auth-verify-email-cover": {
            uri: "authDev/verify-email-cover",
            methods: ["GET", "HEAD"],
        },
        "auth-two-steps-basic": {
            uri: "authDev/two-steps-basic",
            methods: ["GET", "HEAD"],
        },
        "auth-two-steps-cover": {
            uri: "authDev/two-steps-cover",
            methods: ["GET", "HEAD"],
        },
        "auth-register-multisteps": {
            uri: "authDev/register-multisteps",
            methods: ["GET", "HEAD"],
        },
        "auth-lock_screen": {
            uri: "authDev/lock-screen",
            methods: ["GET", "HEAD"],
        },
        "chart-apex": { uri: "chart/apex", methods: ["GET", "HEAD"] },
        "chart-chartjs": { uri: "chart/chartjs", methods: ["GET", "HEAD"] },
        "chart-echarts": { uri: "chart/echarts", methods: ["GET", "HEAD"] },
        "map-leaflet": { uri: "maps/leaflet", methods: ["GET", "HEAD"] },
    },
};

if (typeof window !== "undefined" && typeof window.Ziggy !== "undefined") {
    Object.assign(Ziggy.routes, window.Ziggy.routes);
}

export { Ziggy };
