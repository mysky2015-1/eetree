<template>
  <div class="panel panel-default">
    <div class="panel-heading">我的文档</div>
    <b-button @click="newCategory">新建文件夹</b-button>
    <b-button @click="newDoc">新建文档</b-button>
    <ul class="list-group">
      <li class="list-group-item" v-for="row in categories" :key="row.id">
        <router-link :to="{path:'/doc/list/' + row.id}">
					{{ row.name }}
        </router-link>
        <span class="float-right" @click="showMove(row)">移动到</span>
        <span class="float-right" @click="editCategory(row)">重命名</span>
        <span class="float-right" @click="delCategory(row)">删除</span>
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
        <span class="float-right" @click="delDoc(row)">删除</span>
      </li>
    </ul>
    <div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="categoryModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="categoryModalLabel">{{ dialogType==='new'?'新建文件夹':'重命名' }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input ref="categoryName" id="categoryName" class="form-control" v-model="category.name" @focus="focusCategoryName($event)" required>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
            <button type="button" class="btn btn-primary" @click="submitCategory">提交</button>
          </div>
        </div>
      </div>
    </div>
    <b-modal title="移动到" @ok="moveCategory()">
      category tree
    </b-modal>

  <b-modal id="modal-1" title="BootstrapVue">
    <p class="my-4">Hello from modal!</p>
  </b-modal>

  </div>
</template>
<script>
var defaultCategory = {
  id: 0,
  name: '新建文件夹',
}
var modalFun = {
  show: function() {
    $('#categoryModal').on('shown.bs.modal', function (e) {
      $('#categoryName').focus();
    })
    $('#categoryModal').modal('show');
  },
  hide: function() {
    $('#categoryModal').modal('hide');
  }
};
import { getDocList, newCategory, editCategory, delCategory, moveCategory, delDoc, newDoc } from '../../js/api';
import { deepClone } from '../../js/utils';
export default{
  data() {
    return {
      parent_id: this.$route.params.id || 0,
      docs: [],
      categories: [],
      dialogType: 'new',
      category: Object.assign({}, defaultCategory),
      destCategory: Object.assign({}, defaultCategory),
    }
  },
  created() {
    this.getDocList();  
	},
  methods: {
    getDocList() {
      getDocList(this.parent_id).then((res) => {
				const data = res.data
				this.docs = data.data.docs;
				this.categories = data.data.categories;
			})
    },
    newDoc() {
      newDoc().then((res) => {
				location.href = res.data.data.url;
			})
    },
    focusCategoryName(event) {
      event.currentTarget.select();
    },
    newCategory() {
      this.dialogType = 'new'
      this.category = Object.assign({}, defaultCategory)
      modalFun.show()
    },
    editCategory(row) {
      this.dialogType = 'edit'
      this.category = deepClone(row)
      modalFun.show()
    },
    submitCategory() {
      if (this.dialogType === 'new') {
        newCategory({name: this.category.name, parent_id: this.parent_id}).then((res) => {
          this.$bvToast.toast('操作成功', {
            title: 'Success',
            variant: 'success',
          })
          this.category.id = res.data.data.id
          this.categories.push(this.category)
          modalFun.hide()
        });
      } else {
        editCategory(this.category.id, {name: this.category.name}).then(() => {
          this.$bvToast.toast('操作成功', {
            title: 'Success',
            variant: 'success',
          })
          for (let index = 0; index < this.categories.length; index++) {
            if (this.categories[index].id === this.category.id) {
              this.categories[index].name = this.category.name
              break
            }
          }
          modalFun.hide()
        });
      }
    },
    delCategory(row) {
      this.$bvModal.msgBoxConfirm('确定要删除文件夹以及其中的文档吗?', {
        okTitle: '确定',
        cancelTitle: '取消',
      }).then(confirmOk => {
        if (confirmOk === true) {
          delCategory(row.id).then(() => {
            this.$bvToast.toast('操作成功', {
              title: 'Success',
              variant: 'success',
            })
            for (let index = 0; index < this.categories.length; index++) {
              if (this.categories[index].id === row.id) {
                this.categories.splice(index, 1)
                break
              }
            }
          });
        }
      })
    },
    showMove(row) {
      this.category = deepClone(row)
      allCategories()
    },
    moveCategory() {
      if (this.category.id === this.destCategory.id) {
        return false;
      }
      moveCategory(this.category.id, this.destCategory.id).then(() => {
        this.$bvToast.toast('操作成功', {
          title: 'Success',
          variant: 'success',
        })
        for (let index = 0; index < this.categories.length; index++) {
          if (this.categories[index].id === row.id) {
            this.categories.splice(index, 1)
            break
          }
        }
      });
    }
	},
	watch: {
    '$route' (to, from) {   
			this.$router.go(0);   
	  }
	}
};
</script>