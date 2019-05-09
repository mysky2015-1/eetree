<template>
  <div class="panel panel-default">
    <div class="panel-heading">我的文档</div>
    <button type="button" class="btn btn-primary">新建分类</button>
    <a class="btn btn-primary" href="/doc/new">新建文档</a>
    <ul class="list-group">
      <li class="list-group-item" v-for="row in categories" :key="row.id">
        <router-link :to="{path:'/doc/list/' + row.id}">
					{{ row.name }}
        </router-link>
      </li>
      <li class="list-group-item" v-for="row in docs" :key="row.id">
        <a v-if="row.status != 1" :href="'/doc/edit/' + row.id">
          {{ row.title }}
        </a>
        <span v-if="row.status == 1">
          {{ row.title }}
        </span>
        <span class="float-right">{{ row.created_at }}</span>
        <a v-if="row.doc_id !== 0" class="float-right" :href="'/doc/detail/' + row.doc_id">
          查看
        </a>
      </li>
    </ul>
  </div>
</template>
<script>
import { getDocList } from '../../js/api';
export default{
  data() {
    return {
      docs: [],
      categories: [],
      // total: 0,
      // listQuery: {
      //   page: 1,
      //   limit: 10
      // }
    }
  },
  created() {
    this.getDocList(this.$route.params.id || 0);  
	},
  methods: {
    getDocList(id) {
      getDocList(id).then((res) => {
				const data = res.data
				this.docs = data.data.docs;
				this.categories = data.data.categories;
			})
		}
	},
	watch: {
    '$route' (to, from) {   
			this.$router.go(0);   
	  }
	}
};
</script>