export default[
    { path: '', redirect: '/doc/list' },
    { path: '/doc/list/:id?', components: require('../page/doc/list.vue') },
];