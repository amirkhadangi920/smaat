<template>
  <div :style="{ position: 'relative', zIndex: 10 }">
    <div class="row" v-if="is_loaded">
      <div class="col-12 text-right">
        <div class="pull-right">
          <h1 class="animated bounceInRight delay-first" :style="{ color: '#fff', fontWeight: 'bold', textShadow: '0px 3px 15px #333' }">
            <span v-if="$route.params.id" dir="rtl">
              ویرایش <span :style="{ color: '#ff3d3d', fontSize: '24px' }">{{ form_data.name }}</span>
            </span>
            <span v-else>
              ثبت <span :style="{ color: '#ff3d3d' }">محصول</span> جدید
            </span>
            <i class="header-nav-icon tim-icons icon-align-left-2" :style="{fontSize: '25px'}"></i>
          </h1>
          <h6 class="header-description animated bounceInRight delay-secound">از طریق فرم زیر میتوانید به صورت کامل اطلاعات محصول جدید خود را به ثبت برسانید</h6>
        </div>
        <div class="pull-left animated bounceInDown delay-last">
          <base-button @click="$router.push('/panel/product')" size="sm" type="warning" class="pull-left">
            <i class="tim-icons icon-double-left"></i>
            بازگشت
          </base-button>
        </div>
      </div>
    </div>

    <md-tabs class="animated bounceInUp delay-last" v-if="is_loaded" md-active-tab="tab-info" @md-changed="checkNewPosts">
      <md-tab id="tab-variations" md-label="تنوع محصولات" v-if="$route.params.id">
        <div class="row">
          <div class="col-12 text-right">
            <div class="pull-right">
              <h3 class="animated bounceInRight delay-first mb-0">
                <i class="tim-icons icon-align-left-2" :style="{fontSize: '25px'}"></i>
                مدیریت تنوع های محصول
              </h3>
              <h6 class="text-muted animated bounceInRight delay-secound">با استفاده از بخش زیر میتوانید کلیه تنوع های محصول <b>{{ this.form_data.name }}</b> را مدیریت کنید</h6>
            </div>
            <div class="pull-left animated bounceInDown delay-last">
              <base-button @click="createVariation" type="success" size="sm">
                <i class="tim-icons icon-simple-add"></i>
                افزودن تنوع جدید
              </base-button>
            </div>
          </div>
        </div>

        <base-table
          class="p-3"
          :style="{ width: '100%' }"
          :tableData="form_data.variations"
          :has_animation="false"
          type="variation"
          group="product"
          label="تنوع محصول"
          :fields="getVariationFields"
          :has_loaded="is_loaded"
          :methods="{ deleteSingle: deleteVariation, edit: editVariation }"
          :canSelect="false"
          :has_operation="true"
          :has_times="false"
        >
          <template #sales_price-body="props">
            {{ props.row.sales_price | comma }}  <span class="text-muted text-small mr-1" :style="{fontSize: '10px'}">تومان</span>
          </template>

          <template #inventory-body="props">
            <span v-if="props.row.inventory">
              {{ props.row.inventory | comma }} <span class="text-muted mr-1" :style="{fontSize: '10px'}"> {{ form_data.unit.title }}</span>
            </span>
            <span v-else-if="props.row.inventory === 0" class="text-danger">
              ناموجود
            </span>
            <span v-else class="text-success">
              بدون محدودیت
            </span>
          </template>

          <template #sending_time-body="props">
            <span v-if="props.row.sending_time">
              {{ props.row.sending_time }} <span class="text-muted mr-1" :style="{fontSize: '10px'}"> روز</span>
            </span>
            <span v-else class="text-danger">نا معلوم</span>
          </template>

          <template #features-body="props">
            <div>
              <div>
                <span class="badge badge-info feature-data" :style="{ background: props.row.color.code }" v-if="props.row.color">
                  <i class="tim-icons icon-bank"></i>
                  رنگ {{ props.row.color.name }}
                </span>
              </div>
              <div>
                <span class="badge badge-info feature-data" v-if="props.row.size">
                  <i class="tim-icons icon-bank"></i>
                  سایز {{ props.row.size.name }}
                </span>
              </div>
              <div>
                <span class="badge badge-warning feature-data" v-if="props.row.warranty">
                  <i class="tim-icons icon-bank"></i>
                  گارانتی {{ props.row.warranty.title }}
                </span>
              </div>
            </div>
          </template>
        </base-table>
      </md-tab>

      <md-tab id="tab-specifications" md-label="اطلاعات فنی">
        <div class="col-md-12">
          <remote-select
            v-if="is_loaded"
            :filters="categoriesFilter"
            type="specs"
            label="جدول مشخصات"
            icon="icon-tablet-2"
            placeholder="لطفا جدول مشخصات محصول را انتخاب کنید"
            fields="id title"
            v-model="form_data.spec.id"
            :defaults="[form_data.spec]"
          />
        </div>

        <hr />
        <div v-for="(header, index) in form_data.spec.headers" :key="header.id">
          <h3 class="mb-0">
            <i class="text-warning tim-icons icon-molecule-40"></i>
            {{ header.title }}
          </h3>
          <span class="text-muted mb-3">{{ header.description }}</span>

          <div class="row">
            <div
              :class="getWidthClass(row, indexRow, header.rows.length) ? 'col-md-12' : 'col-md-6'
              "
              v-for="(row, indexRow) in header.rows"
              :key="row.id"
            >
              <br/>
              <md-chips
                v-model="specifications[row.id]"
                v-if="row.defaults.length === 0 && row.is_multiple"
                md-placeholder="افزودن ..."
              >
                <label>{{ row.title }}</label>
                <span class="md-helper-text">{{ row.description }}</span>
              </md-chips>

              <md-field v-else>
                <label>{{ row.title }}</label>
                <span class="md-prefix">{{ row.prefix }}</span>

                <md-input
                  v-model="specifications[row.id]"
                  v-if="row.defaults.length === 0 && !row.is_multiple"
                />

                <md-select
                  :multiple="row.is_multiple"
                  v-model="specifications[row.id]"
                  v-if="row.defaults.length !== 0"
                >
                  <md-option v-for="value in row.defaults" :key="value.id" :value="value.id">{{ value.value }}</md-option>
                </md-select>

                <span class="md-suffix">{{ row.postfix }}</span>
                <span class="md-helper-text" :title="row.help">{{ row.help }}</span>
              </md-field>
            </div>
          </div>

          <hr v-if="index !== form_data.spec.headers.length - 1" />
        </div>

        <transition name="fade">
          <md-empty-state
            v-show="form_data.spec.headers.length === 0"
            md-icon="search"
            md-label="متاسفانه هیچ داده ای یافت نشد :("
            md-description="لطفا یک جدول معتبر انتخاب کنید که دارای سطر و ردیف باشد">
          </md-empty-state>
        </transition>
        <br/>
      </md-tab>
      
      <md-tab id="tab-accessories" md-label="اقلام همراه">
        <div class="row p-2">
          <div class="col-md-12">
            <remote-select
              v-if="is_loaded"
              :filters="categoriesFilter"
              type="products"
              label="محصول"
              icon="icon-molecule-40"
              placeholder="لطفا بخشی از نام محصول را تایپ کنید"
              labelfield="name"
              fields="id name code photos { id file_name thumb }"
              ref="accessories_input"
              v-model="accessories_input"
            >
              <template #content="props">
                <img class="tilt" :src="props.item.photos && props.item.photos.length !== 0 ? props.item.photos[0].thumb : '/images/placeholder.png'" />
                <span>{{ props.item.name }} - <span class="text-muted">{{ props.item.code }}</span></span>
              </template>
            </remote-select>
          </div>

          <div class="col-md-12">
            <base-table
              :style="{ width: '100%' }"
              :tableData="form_data.accessories"
              :has_animation="false"
              type="brand"
              group="feature"
              label="اکسسوری"
              :fields="[
                {
                  field: 'photo',
                  label: 'تصویر',
                  icon: 'icon-caps-small'
                }, {
                  field: 'name',
                  label: 'نام محصول',
                  icon: 'icon-single-copy-04'
                }, {
                  field: 'code',
                  label: 'کد محصول',
                  icon: 'icon-single-copy-04'
                }
              ]"
              :methods="{ deleteSingle: (index) => form_data.accessories.splice(index, 1) }"
              :has_loaded="is_loaded"
              :canEdit="false"
              :has_times="false"
              :has_operation="true"
            >
              <template #photo-body="slotProps">
                <img class="tilt" :src="slotProps.row.photos && slotProps.row.photos.length !== 0 ? slotProps.row.photos[0].thumb : '/images/placeholder.png'" />
              </template>
            </base-table>
          </div>
        </div>
      </md-tab>
      
      <md-tab id="tab-advantages" md-label="معایب و مزایا">
        <div class="row">
          <div class="col-md-12 advantages">
            <md-chips v-model="form_data.advantages" md-placeholder="افزودن مزیت ...">
              <label>مزایای محصول</label>
              <span class="md-helper-text">مزیت های محصول خود را در این قسمت وارد کنید</span>
            </md-chips>
          </div>
          <div class="col-md-12 disadvantages">
            <md-chips v-model="form_data.disadvantages" md-placeholder="افزودن عیب ...">
              <label>معایب محصول</label>
              <span class="md-helper-text">معایب محصول خود را در این قسمت وارد کنید</span>
            </md-chips>
          </div>
        </div>
      </md-tab>

      <md-tab id="tab-images" md-label="تصاویر محصول" dir="ltr">
        <div class="row">
          <div class="col-md-5" :style="{ borderLeft: '1px solid #c7c7c7' }">
            <md-field :class="getValidationClass('aparat_video')">
              <label>لینک ویدیو آپارات</label>
              <!-- <md-input v-model="aparat_video" :maxlength="$v.aparat_video.$params.maxLength.max" /> -->
              <md-input v-model="form_data.aparat_video" />
              <i class="md-icon tim-icons icon-video-66"></i>
              <span class="md-helper-text">برای مثال : https://www.aparat.com/v/TJcin</span>
              <span class="md-error" v-show="!$v.aparat_video.required">لطفا شناسه محصول را وارد کنید</span>
            </md-field>

            <br/>

            <div id="aparat_video_frame" v-if="is_loaded_video">
              <script type="text/JavaScript" :src="`https://www.aparat.com/embed/${form_data.aparat_video.replace('https://www.aparat.com/v/', '').trim()}?data[rnddiv]=aparat_video_frame&data[responsive]=yes`">
              </script>
            </div>
          </div>

          <div class="col-md-7">
            <label>تصاویر محصول</label>

            <!-- <div class="row mb-2 product-colors-thumbnails" v-if="$refs.colors">
              <span v-for="img in form_data.photos.filter(i => i.color)" :key="img.name" class="p-1">
                <img
                  :style="{ border: `2px solid ${
                    $refs.colors.options.filter(i => i.id === img.color)[0] ? .code}
                  ` }"
                  :src="img.url" 
                  alt="product image"
                />
              </span>
            </div> -->

            <el-upload
              class="upload-photo-gallery"
              action="https://jsonplaceholder.typicode.com/posts/"
              :auto-upload="false"
              list-type="picture-card"
              :file-list="form_data.photos"
              :on-change="handleSelectPhotos"
              :on-remove="handleRemove">
              <i class="el-icon-plus"></i>
            </el-upload>
            <el-dialog :visible.sync="dialogVisible">
              <img width="100%" :src="dialogImageUrl" alt="">
            </el-dialog>
          </div>
        </div>
      </md-tab>

      <md-tab id="tab-description" md-label="توضیحات محصول">
        <base-input label="نقد و بررسی مختصر">
          <ckeditor :editor="editor" :config="{
              height: 300,
              filebrowserUploadUrl: '/upload',
              defaultLanguage: 'fa'
            }"
            v-model="form_data.short_review"
          ></ckeditor>
          <small slot="helperText" class="form_data-text text-muted">متن کامل توضیحات و نقد و بررسی محصول</small>
        </base-input>
        <br/>

        <md-chips v-model="form_data.tags" md-placeholder="افزودن کلمه کلیدی ...">
          <label>کلمات کلیدی محصول</label>
          <span class="md-helper-text">کلمات کلیدی مرتبط با محصول خود را وارد کنید</span>
        </md-chips>
        <br/>
        
        <base-input label="نقد و بررسی تخصصی">
          <ckeditor :editor="editor" v-model="form_data.expert_review" ></ckeditor>
          <small slot="helperText" class="form_data-text text-muted">متن کامل توضیحات و نقد و بررسی محصول</small>
        </base-input>
      </md-tab>
      
      <md-tab id="tab-info" md-label="درباره محصول">
        <div class="row">
          <div class="col-md-6">
            <md-field :class="getValidationClass('name')">
              <label>نام محصول</label>
              <md-input v-model="form_data.name" :maxlength="$v.name.$params.maxLength.max" />
              <i class="md-icon tim-icons icon-tag"></i>
              <span class="md-helper-text">برای مثال : گوشی موبایل Samsung Galaxy S10</span>
              <span class="md-error" v-show="!$v.name.required">لطفا نام محصول را وارد کنید</span>
            </md-field>
          </div>

          <div class="col-md-6">
            <md-field :class="getValidationClass('code')">
              <label>شناسه محصول</label>
              <md-input v-model="form_data.code" :maxlength="$v.code.$params.maxLength.max" />
              <i class="md-icon tim-icons icon-badge"></i>
              <span class="md-helper-text">برای مثال : SMT-1002</span>
              <span class="md-error" v-show="!$v.code.required">لطفا شناسه محصول را وارد کنید</span>
            </md-field>
          </div>
          <br/>

          <div class="col-md-12">
            <md-chips v-model="form_data.second_name" md-placeholder="افزودن نام ...">
              <label>دیگر نام های محصول</label>
              <span class="md-helper-text">مزیت های محصول خود را در این قسمت وارد کنید</span>
            </md-chips>
          </div>
        </div>
        <br/>

        <md-field :class="getValidationClass('description')">
          <label>توضیح کوتاه</label>
          <md-textarea v-model="form_data.description" md-autogrow :maxlength="$v.description.$params.maxLength.max"></md-textarea>
          <i class="md-icon tim-icons icon-align-center"></i>
          <span class="md-helper-text">توضیحی مختصر درباره این محصول</span>
          <span class="md-error" v-show="!$v.description.required">لطفا شناسه محصول را وارد کنید</span>
        </md-field>
        <br/>

        <div class="row">
          <div class="col-md-6">
            <base-input label="دسته بندی های محصول">
              <el-tree
                class="rtl"
                dir="ltr"
                :data="$store.state.group.category"
                :props="defaultProps"
                :accordion="true"
                ref="categories"
                show-checkbox
                node-key="id"
                @check-change="changeSelectedCategories"
                :default-checked-keys="form_data.categories.map(i => i.id)"
                :default-expanded-keys="form_data.categories.map(i => i.id)"
                empty-text="هیچ دسته بندی ای یافت نشد :("
              >
              </el-tree>
              <small slot="helperText" id="emailHelp" class="form-text text-muted">برای انتخاب هر دسته بندی تیک قبل آن را انتخاب کنید</small>
            </base-input>
          </div>

          <div class="col-md-6">
            <remote-select
              v-if="is_loaded"
              :filters="categoriesFilter"
              type="brands"
              label="برند"
              icon="icon-molecule-40"
              placeholder="لطفا برند محصول خود را انتخاب کنید"
              labelfield="name"
              fields="id name logo { id file_name thumb }"
              v-model="form_data.brand.id"
              :defaults="[form_data.brand]"
            >
              <template #content="props">
                <img :src="props.item.logo ? props.item.logo.thumb : '/images/placeholder.png'" alt="brand logo">
                <span>{{ props.item.name }}</span>
              </template>
            </remote-select>
            <br/>

            <remote-select
              v-if="is_loaded"
              :filters="categoriesFilter"
              type="units"
              label="واحد اندازه گیری"
              icon="icon-components"
              placeholder="لطفا واحد اندازه گیری محصول را انتخاب کنید"
              fields="id title"
              v-model="form_data.unit.id"
              :defaults="[form_data.unit]"
            />
            <br/>
            <remote-select
              v-if="is_loaded"
              :filters="categoriesFilter"
              multiple
              type="colors"
              label="رنگ محصول"
              labelfield="name"
              icon="icon-palette"
              ref="colors"
              placeholder="لطفا رنگ محصول را انتخاب کنید"
              fields="id name code"
              v-model="colors_id"
              :defaults="form_data.colors"
            >
              <template #content="props">
                <span :style="{ borderRight: `3px solid ${props.item.code}` }" class="pr-2">{{ props.item.name }}</span>
              </template>
            </remote-select>
            <br/>

            <remote-select
              v-if="is_loaded"
              type="labels"
              label="لیبل محصول"
              icon="icon-molecule-40"
              placeholder="لطفا لیبل محصول خود را انتخاب کنید"
              fields="id title color"
              v-model="form_data.label.id"
              :defaults="[form_data.label]"
            >
              <template #content="props">
                <span :style="{ borderRight: `3px solid ${props.item.color}` }" class="pr-2">{{ props.item.title }}</span>
              </template>
            </remote-select>
            <br/>
            <div class="d-flex align-items-center justify-content-center" dir="ltr">
              <el-switch
                v-model="form_data.is_active"
                active-text="ثبت"
                inactive-text="پیش نویس"
                active-color="#ff8d72"
              >
              </el-switch>
            </div>
          </div>
        </div>
        <br/>
      </md-tab>
    </md-tabs>

    <div class="row" v-if="is_loaded">
      <base-button
        v-if="activeTab !== 'tab-variations'"
        :loading="attr('is_mutation_loading')"
        size="sm"
        type="success"
        class="pull-left mt-3"
        @click="update()"
      >
        <transition name="fade" mode="out-in">
          <semipolar-spinner
            :animation-duration="2000"
            :size="17"
            color="#fff"
            v-if="attr('is_mutation_loading')"
          />
          <span v-else class="pull-right ml-2" >
            <i v-if="attr('is_creating')" class="tim-icons icon-simple-add"></i>
            <i v-else class="tim-icons icon-pencil"></i>
          </span>
        </transition>
        ذخیره
      </base-button>

      <base-button @click="$router.push('/panel/product')" size="sm" type="danger" class="pull-left mt-3 ml-2">
        <i class="tim-icons icon-simple-remove"></i>
        بازگشت
      </base-button>
    </div>

    <md-dialog :md-active.sync="$store.state.product.is_open.variation" class="text-right" dir="rtl">
      <md-dialog-title>
        <h2 class="modal-title">
          {{ $store.state.product.is_creating.variation ? 'ثبت تنوع جدید' : 'ویرایش تنوع' }}
        </h2>
        <p>از طریق فرم زیر میتوانید تنوع محصول {{ $store.state.product.is_creating.variation ? 'جدید ثبت کنید' : 'مورد نظر خود را ویرایش کنید' }}</p>
      </md-dialog-title>

      <div class="md-dialog-content">
        <div class="p-2">
          <form @submit.prevent>
            <md-field>
              <label>قیمت</label>
              <md-input type="number" v-model="form_variation.sales_price" />
              <i class="md-icon tim-icons icon-coins"></i>
              <span class="md-helper-text">قیمت فروش محصول</span>
            </md-field>

            <md-field>
              <label>موجودی در انبار</label>
              <md-input type="number" v-model="form_variation.inventory" />
              <i class="md-icon tim-icons icon-bag-16"></i>
              <span class="md-helper-text">توسط فاکتور فروش ها مدیریت خواهد شد</span>
            </md-field>
            <br/>
            <md-field>
              <label>زمان ارسال</label>
              <md-input type="number" v-model="form_variation.sending_time" />
              <i class="md-icon tim-icons icon-bag-16"></i>
              <span class="md-helper-text">میانگین زمان ارسال این تنوع محصول</span>
            </md-field>
            <br/>

            <md-field v-if="is_loaded && $refs.colors">
              <label>رنگ</label>
              <md-select v-model="form_variation.color_id">
                <md-option
                  :style="{ borderRight: `5px solid ${value.code}` }"
                  v-for="value in $refs.colors.options.filter(i => this.colors_id.includes(i.id))"
                  :key="value.id"
                  :value="value.id"
                >
                  {{ value.name }}
                </md-option>
              </md-select>
              <i class="md-icon tim-icons icon-palette"></i>
              <span class="md-suffix"></span>
              <span class="md-helper-text">لطفا رنگ تنوع محصول را انتخاب کنید</span>
            </md-field>
            <br/>
            <remote-select
              v-if="is_loaded"
              :filters="categoriesFilter"
              type="warranties"
              label="گارانتی"
              icon="icon-refresh-01"
              placeholder="لطفا گارانتی تنوع محصول را انتخاب کنید"
              fields="id title expire logo { id file_name thumb }"
              v-model="form_variation.warranty_id"
              :defaults="[form_variation.warranty]"
            >
              <template #content="props">
                <img :src="props.item.logo ? props.item.logo.thumb : '/images/placeholder.png'" alt="brand logo">
                <span>{{ props.item.title }}</span>
              </template>
            </remote-select>
            <br/>
            <remote-select
              v-if="is_loaded"
              :filters="categoriesFilter"
              type="sizes"
              label="سایز"
              icon="icon-chart-bar-32"
              placeholder="لطفا سایز تنوع محصول را انتخاب کنید"
              labelfield="name"
              fields="id name"
              v-model="form_variation.size_id"
              :defaults="[form_variation.size]"
            />
            <br/>
          </form>
        </div>
      </div>

      <md-dialog-actions>
        <base-button
          size="sm"
          class="ml-2"
          type="danger"
          @click="$store.state.product.is_open.variation = false"
        >
          <i class="tim-icons icon-simple-remove"></i>
          لغو
        </base-button>
        
        <base-button
          size="sm"
          :loading="$store.state.product.is_mutation_loading.variation"
          :type="$store.state.product.is_creating.variation ? 'success' : 'warning'"
          @click="$store.state.product.is_creating.variation ? storeVariation() : updateVariation()"
        >
          <transition name="fade" mode="out-in">
            <semipolar-spinner
              :animation-duration="2000"
              :size="17"
              color="#fff"
              v-if="$store.state.product.is_mutation_loading.variation"
            />
            <span v-else class="pull-right ml-2" >
              <i v-if="$store.state.product.is_creating.variation" class="tim-icons icon-simple-add"></i>
              <i v-else class="tim-icons icon-pencil"></i>
            </span>
          </transition>
          {{ $store.state.product.is_creating.variation ? 'ذخیره' : 'بروز رسانی' }} تنوع محصول
        </base-button>
      </md-dialog-actions>
    </md-dialog>

    <transition name="fade">
      <div class="main-panel-loading" v-if="!is_loaded">
        <fingerprint-spinner
          :animation-duration="1000"
          :size="100"
          color="#fff"
        />
      </div>
    </transition>

    <transition name="loading">
      <div class="query-loader" v-if="attr('is_query_loading')">
        <half-circle-spinner
          :animation-duration="800"
          :size="40"
          color="#fff"
        />
      </div>
    </transition>
  </div>
</template>

<script>
import RemoteSelect from '../../components/RemoteSelect'
import BaseTable from '../../components/BaseTable'
import ClassicEditor from '@ckeditor/ckeditor5-build-classic'
import Binding, { bind } from '../../mixins/binding'
import { validationMixin } from 'vuelidate'
import vuexHelper from '../../mixins/vuexHelper'
import { required, maxLength } from 'vuelidate/lib/validators'
import createMixin from '../../mixins/createMixin'
import filtersHelper from '../../mixins/filtersHelper'
import deleteMixin from '../../mixins/deleteMixin'
import {SemipolarSpinner, HalfCircleSpinner, FingerprintSpinner} from 'epic-spinners'

export default {
  components: {
    BaseTable,
    RemoteSelect,
    SemipolarSpinner,
    HalfCircleSpinner,
    FingerprintSpinner
  },
  mixins: [
    Binding,
    validationMixin,
    vuexHelper,
    createMixin,
    filtersHelper,
    deleteMixin
  ],
  metaInfo() {
    return {
      title: this.$route.params.id ? 'ثبت محصول' : this.form_data.name,
    }
  },
  data() {
    return {
      type: 'product',
      group: 'product',

      form_data: {
        name: '',
        code: '',
        description: '',
        aparat_video: '',
        short_review: '',
        expert_review: '',
        is_active: true,
        is_active: true,

        tags: [
          // 
        ],
        colors: [
          // 
        ],
        second_name: [
          // 
        ],
        photos: [
          // 
        ],
        advantages: [
          // 
        ],
        disadvantages: [
          // 
        ],
        spec: {
          // 
        },
        brand: {
          // 
        },
        unit: {
          // 
        },
        label: {
          // 
        },
        categories: [
          // 
        ],
        variations: [
          // 
        ],
        accessories: [
          // 
        ],
        spec: {
          headers: {
            rows: [

            ]
          }
        }
      },
      form_variation: {
        sales_price: null,
        inventory: null,
        sending_time: null,
        color_id: null,
        size_id: null,
        warranty_id: null,
        color: {
          // 
        },
        size: {
          // 
        },
        warranty: {
          // 
        }
      },
      specifications: {
        // 
      },
      deleted_images: [
        // 
      ],
      
      accessories_input: null,
      is_loaded: false,
      is_loaded_video: false,
      dialogImageUrl: '',
      dialogVisible: false,
      colors_id: [],
      color_id: [],

      defaultProps: {
        children: 'childs',
        label: 'title',
      },
      activeTab: 'tab-info',
      editor: ClassicEditor,
    }
  },
  validations: {
    name: {
      required,
      maxLength: maxLength(50)
    },
    code: {
      maxLength: maxLength(20)
    },
    description: {
      maxLength: maxLength(255)
    },
    aparat_video: {},
    label: {},
    status: {},
    review: {},
    note: {
      maxLength: maxLength(255)
    },
    advantages: {},
    disadvantages: {},
  },
  computed: {
    canAddVariation() {
      return !this.form_data.variations[ this.form_data.variations.length - 1 ].price
    },
    allQuery()
    {
      if ( this.type === 'variation' )
      {
        return `
          sales_price
          inventory
          sending_time
          color { id name code }
          warranty { id title expire }
          size { id name }
        `
      } 

      return `
        id name second_name code description aparat_video
        categories { id title }
        colors { id name code }
        unit { id title }
        label { id title color }
        brand { id name logo { id file_name thumb } }
        tags { name }
        short_review expert_review
        photos { id file_name thumb small custom_properties { color } }
        advantages disadvantages tags { name }
        is_active
        spec {
          id title headers {
            id title description
            rows {
              id title description help
              prefix postfix is_multiple
              data {
                id data values { id value }
              }
              defaults { id value }
            }
          }
        }
        accessories {
          id name code photos { id file_name thumb }
        }
      `
    },
    categoriesFilter()
    {
      return `categories: [${ this.form_data.categories.map(i => i.id).join(',') }]`
    },
    variation_form()
    {
      return this.$store.state.product.form.variation
    },
    getVariationFields()
    {
      return [
        {
          field: 'sales_price',
          label: 'قیمت فروش',
          icon: 'icon-caps-small'
        }, {
          field: 'inventory',
          label: 'موجودی انبار',
          icon: 'icon-single-copy-04'
        }, {
          field: 'sending_time',
          label: 'زمان ارسال',
          icon: 'icon-time-alarm'
        }, {
          field: 'features',
          label: 'ویژگی ها',
          icon: 'icon-time-alarm'
        }
      ]
    }
  },
  mounted()
  {
    this.$store.dispatch('getData', {
      group: 'group',
      type: 'category',
    })

    if ( this.$route.params.id )
    {
      this.setAttr('selected', { id: this.$route.params.id })
      this.setAttr('is_creating', false)

      axios.get('/graphql/auth', {
        params: {
          query: `{
            product (id: "${this.$route.params.id}") {
              ${this.allQuery}
              variations {
                id
                sales_price
                inventory
                sending_time
                color { id name code }
                warranty { id title expire }
                size { id name }
              }
            }
          }`
        }
      })
      .then(({data}) => {
        if ( data.data.product.spec && data.data.product.spec.headers.length )
          this.handleSpecification(data.data.product.spec.headers)
        else if ( !data.data.product.spec )
            data.data.product.spec = { headers: [] }

        if ( data.data.product.aparat_video )
          data.data.product.aparat_video = `https://www.aparat.com/v/${data.data.product.aparat_video}`
        
        if ( data.data.product.tags.length !== 0 )
          data.data.product.tags = data.data.product.tags.map(i => i.name)

        if ( !data.data.product.unit )
          data.data.product.unit = { id: null }

        if ( !data.data.product.brand )
          data.data.product.brand = { id: null }

        if ( !data.data.product.label )
          data.data.product.label = { id: null }

        if ( !data.data.product.spec )
          data.data.product.spec = { id: null }
        

        if ( data.data.product.photos.length !== 0 )
        {
          data.data.product.photos = data.data.product.photos.map(i => {
            return {
              id: i.id,
              color: i.custom_properties.color,
              name: i.file_name,
              url: i.small
            }
          })
        }

        this.colors_id = data.data.product.colors.map(i => i.id)
        this.form_data = data.data.product;
      })
      .then(() => this.is_loaded = true)
      .catch( error => console.log(error.response) )
    }
    else 
    {
      this.setAttr('selected', { id: null })
      this.setAttr('is_creating', true)
      this.is_loaded = true
    }
  },
  methods: {
    checkNewPosts (activeTab) {
      this.activeTab = activeTab
    },
    changeSelectedCategories() {
      this.form_data.categories = this.$refs.categories.getCheckedKeys().map(i => { return { id: i } })
    },
    handleRemove(file, fileList) {
      this.form_data.photos = fileList
      this.deleted_images = [ ...this.deleted_images, file ]
    },
    handleSelectPhotos(file, fileList) {
      let colors = {}
      let selected_colors = this.$refs.colors.options.filter(i => this.colors_id.includes(i.id))

      if ( selected_colors.length)
      {
        selected_colors.map(i => colors[i.id] = i.name)

        this.$swal.fire({
          title: 'رنگ مرتبط با این عکس را انتخاب کنید :',
          text: "در صورت مشخص کردن رنگ برای عکس ها ، در صفحه محصولات با کلیک بر روی نام هر رنگ عکس مرتبط نمایش داده خواهد شد",
          input: selected_colors.length < 5 ? 'radio' : 'select',
          inputOptions: colors,
          showCancelButton: true,
          confirmButtonText: 'ثبت رنگ',
          cancelButtonText: 'لغو'
        }).then((result) => {
          if (result.value)
            file.color = result.value
        })
      }

      this.form_data.photos = _.uniqBy([ ...this.form_data.photos, file ], 'name')
    },
    getWidthClass(row, index, count)
    {
      if ( count % 2 === 1 && index === count - 1)
        return true

      return row.defaults.length === 0 && row.is_multiple
    },
    createVariation()
    {
      this.form_variation = {
        sales_price: null,
        inventory: null,
        sending_time: null,
        color_id: null,
        size_id: null,
        warranty_id: null,
        color: {
          // 
        },
        size: {
          // 
        },
        warranty: {
          // 
        }
      }
      this.label = 'تنوع محصول'
      this.type = 'variation'
      
      this.create()
    },
    editVariation(index, row)
    {
      row.color_id = row.color ? row.color.id : null
      row.size_id = row.size ? row.size.id : null
      row.warranty_id = row.warranty ? row.warranty.id : null

      this.form_variation = row
      this.label = 'تنوع محصول'
      this.type = 'variation'
      
      this.edit(index, row)
    },
    storeVariation()
    {
      this.storeInServer({
        callback: ({data}) => {
          this.form_data.variations.unshift(data)

          this.setAttr('is_open', false)
          this.setAttr('is_creating', false)
        }
      })
    },
    updateVariation()
    {
      this.storeInServer({
        callback: ({data}) => {
          let index = this.attr('selected').index;

          this.form_data.variations[index] = data

          this.setAttr('is_open', false)
        }
      })
    },
    deleteVariation(index, row)
    {
      this.label = 'تنوع محصول'
      this.type = 'variation'

      this.handleDelete(index, row)
    },
    afterDelete(index, row)
    {
      this.form_data.variations.splice(index, 1)
    },
    handlePictureCardPreview(file) {
      this.dialogImageUrl = file.url;
      this.dialogVisible = true;
    },
    handleChangeSpec(row_id, value)
    {
      this.specifications[row_id] = value
    },
    validate()
    {
      return true;
    },
    getVariables()
    {
      if ( this.type === 'variation' )
      {
        return {
          product_id: this.$route.params.id,
          sales_price: this.form_variation.sales_price,
          inventory: this.form_variation.inventory,
          sending_time: this.form_variation.sending_time,
          color_id: this.form_variation.color_id,
          size_id: this.form_variation.size_id,
          warranty_id: this.form_variation.warranty_id
        }
      }

      return {
        name: this.form_data.name,
        code: this.form_data.code,
        second_name: this.form_data.second_name,
        description: this.form_data.description,
        brand_id: this.form_data.brand.id ? this.form_data.brand.id : null,
        label_id: this.form_data.label.id ? this.form_data.label.id : null,
        unit_id: this.form_data.unit.id ? this.form_data.unit.id : null,
        spec_id: this.form_data.spec.id ? this.form_data.spec.id : null,
        short_review: this.form_data.short_review,
        expert_review: this.form_data.expert_review,
        tags: this.form_data.tags,
        advantages: this.form_data.advantages,
        disadvantages: this.form_data.disadvantages,
        is_active: this.form_data.is_active,
        aparat_video: this.form_data.aparat_video,
        categories: this.form_data.categories.map(i => i.id),
        colors: this.colors_id,
        accessories: this.form_data.accessories.map(i => i.id),
        deleted_images: this.deleted_images.filter(i => i.id).map(i => i.id),
        specs: this.getSpecificationsInfo(),
        photos: this.form_data.photos.filter(i => i.raw).map(i => {
          return { color: i.color ? i.color : null, image: null }
        })
      };
    },
    getSpecificationsInfo()
    {
      if ( !this.form_data.spec || !this.form_data.spec.headers.length )
        return null

      const rows = _.flatten( this.form_data.spec.headers.map(i => i.rows) )

      let specs = []

      for (let id in this.specifications)
      {
        let row = rows.filter(i => i.id == id)[0]

        if ( row.defaults.length === 0 && row.is_multiple )
          specs[id] = { data: JSON.stringify( this.specifications[id] ) }

        else if ( row.defaults.length === 0 && !row.is_multiple )
          specs[id] = { data: this.specifications[id] }

        else if ( row.defaults.length !== 0 && row.is_multiple )
          specs[id] = { values: this.specifications[id] }

        else
          specs[id] = { value: this.specifications[id] }

        specs[id].id = id
      }

      return Object.values( specs )
    },
    changeFormData(fd)
    {
      if ( this.form_data.photos.filter(i => i.raw).length === 0 )
        return fd;

      let map = {}

      this.form_data.photos.filter(i => i.raw).forEach((image, index) => {
        map[`images_${index}`] = [`variables.photos.${index}.image`]
        fd.append(`images_${index}`, image.raw) 
      })

      fd.delete('map')
      fd.append('map' , JSON.stringify(map))

      return fd;
    },
    IsJsonString(str)
    {
      try {
          JSON.parse(str);
      } catch (e) {
          return false;
      }
      return true;
    },
    handleSpecification(headers)
    {
      this.specifications = {}

      _.flatten( headers.map(i => i.rows) ).map(i => {

        if ( i.data == null)
          this.specifications[i.id] = i.is_multiple ? [] : null
        else
        {
          this.specifications[i.id] = i.data.values.length === 0 ? i.data.data : i.data.values.map(i => i.id)
          
          if ( i.defaults.length === 0 && i.is_multiple )
            this.specifications[i.id] = i.data.data ? this.IsJsonString(i.data.data) ? JSON.parse( i.data.data ) : [i.data.data] : []

          else if ( i.defaults.length !== 0 && !i.is_multiple )
          {
            if ( Array.isArray(this.specifications[i.id]) )
              this.specifications[i.id] = this.specifications[i.id][0] ? this.specifications[i.id][0] : null

            else 
              this.specifications[i.id] = this.specifications[i.id] ? this.specifications[i.id] : null
          }

          else if ( i.defaults.length !== 0 && i.is_multiple )
            this.specifications[i.id] = i.data.values.map(i => i.id)
        }
      })
      // console.log( this.specifications )
    },
    update()
    {
      this.type = 'product'
      this.label = 'محصول'

      this.storeInServer({
        callback: ({data}) => {
          this.deleted_images = []
          
          const product = this.$store.state.product.product.filter(i => i.id === data.id)

          if ( product.length !== 0 )
          {
            product[0].name = data.name
            product[0].photos = data.photos
            product[0].brand = data.brand
            product[0].categories = data.categories
            product[0].is_active = data.is_active
            product[0].created_at = data.created_at
            product[0].updated_at = data.updated_at
          }
          else
          {
            let arr = this.data()
            
            if ( arr.length )
            {
              arr.unshift({
                id: data.id,
                name: data.name,
                photos: data.photos,
                brand: data.brand,
                is_active: data.is_active,
                categories: data.categories,
                created_at: data.created_at,
                updated_at: data.updated_at,
                votes: { likes: 0, dislikes: 0}
              })
              this.setData( arr )
            }

            this.$router.push(`/panel/product/${data.id}/edit`)
          }
        }
      })
    },
  },
  watch: {
    'form_data.aparat_video': function(newVal, oldVal)
    {
      this.is_loaded_video = false
      setTimeout(() => this.is_loaded_video = true, 100);
    },
    'form_data.spec.id': function(newVal, oldVal)
    {
      if ( ! this.is_loaded ) return

      axios.get('/graphql/auth', {
        params: {
          query: `{
            spec (id: ${newVal}) {
              id title headers {
                id title description
                rows {
                  id title description help
                  prefix postfix is_multiple
                  data { id }
                  defaults { id value }
                }
              }
            }
          }`
        }
      })
      .then(({data}) => {
        this.handleSpecification(data.data.spec.headers)
        this.form_data.spec = data.data.spec;
      })
      .catch( error => console.log(error.response) )
    },
    accessories_input: function(newVal, oldVal)
    {
      const product = this.$refs.accessories_input.options.filter(i => i.id === newVal)[0]
      this.form_data.accessories = _.uniqBy([ ...this.form_data.accessories, product ], 'id');
    }
  },
}
</script>

<style scope>
#tab-specifications .md-helper-text {
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
  width: 100%;
}
#tab-specifications .md-suffix, #tab-specifications .md-prefix {
  background: linear-gradient(to bottom right, #ff8d72, #f56c6c);
  padding: 0px 10px;
  color: #fff;
  line-height: 20px;
  border-radius: 5px;
  box-shadow: 0px 4px 25px -6px #f70000, 0px 3px 10px -8px #000;
  text-shadow: 1px 2px 7px #0000005c;
}
#tab-specifications .md-prefix {
  margin-left: 5px;
}

.md-tab {
  text-align: right;
  direction: rtl;
}
.md-button:not([disabled]).md-focused:before, .md-button:not([disabled]):active:before, .md-button:not([disabled]):hover:before {
  opacity: 0;
}
.md-button {
  outline: none !important;
}
.md-tabs-indicator {
  background: rgb(110, 3, 124) !important;
}
.md-tabs-navigation {
  justify-content: center !important;
}
.md-content.md-tabs-content {
  margin-top: 30px;
  text-align: right;
  background: rgb(255, 255, 255);
  box-shadow: 0px 5px 15px -14px #19375a, 0px 4px 10px -11px #0076ff !important;
  border-radius: 5px;
  transition: height 300ms ease 0s;
}
.md-tabs .md-ripple {
  color: #fff;
}

.md-tabs .md-prefix {
  padding-left: 10px;
}

.md-tabs .md-suffix {
  padding-right: 10px;
}

.md-select-menu .md-checkbox {
  margin: 0px;
}
.md-checkbox .md-checkbox-container:after {
  width: 15px;
  height: 15px;
  border-radius: 50%;
  background: orange;
}

.upload-photo-gallery img {
  max-height: 100%;
}
.upload-photo-gallery .el-upload.el-upload--picture-card {
  width: 148px;
  margin: 0px 10px;
}

.el-checkbox__inner:hover {
  border-color: #f56c6c;
}
.el-checkbox__input.is-checked .el-checkbox__inner,
.el-checkbox__input.is-indeterminate .el-checkbox__inner {
  background-color: #ff8d72;
  border-color: #f56c6c;
}

.el-switch__label.is-active {
  color: #ff8d72;
}
.md-chips .md-chip {
  background: linear-gradient(to bottom right, #ff8d72, #f56c6c);
  box-shadow: 0px 5px 12px -4px #ff8d72, 0px 4px 8px -5px #000 !important;
  text-shadow: 1px 2px 10px #999;
}
.disadvantages .md-chip {
  background: linear-gradient(to bottom right, #ff4c4c, #fd5d93);
  box-shadow: 0px 5px 12px -4px #ff4c4c, 0px 4px 8px -5px #000 !important;
  text-shadow: 1px 2px 10px #999;
}
.advantages .md-chip {
  background: linear-gradient(to bottom right, #00f2c3, #00caa2);
  box-shadow: 0px 5px 12px -4px #00caa2, 0px 4px 8px -5px #000 !important;
  text-shadow: 1px 2px 10px #999;
}

.product-colors-thumbnails img {
  max-width: 50px;
  max-height: 50px;
}
</style>
