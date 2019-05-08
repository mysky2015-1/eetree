import api from '../api';
export default{
  state: {
    list: [],  // 列表
  },
  mutations: {
    // 注意，这里可以设置 state 属性，但是不能异步调用，异步操作写到 actions 中
    SETLIST(state, list) {
    //   state.list = list;
    },
  },
  actions: {
    getDocList({commit}) {
      api.getDocList().then(function(res) {
        commit('SETLIST', res.data);
      });
    }
  }
}