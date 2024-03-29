// GeneralViews
import NotFound from "../pages/NotFoundPage.vue";

// Admin pages
import Dashboard from "../pages/Dashboard.vue";
import SiteSetting from "../pages/Setting/Site.vue";
import UserSetting from "../pages/Setting/User.vue";
import Brand from '../pages/Feature/Brand.vue';
import Size from '../pages/Feature/Size.vue';
import Color from '../pages/Feature/Color.vue';
import Warranty from '../pages/Feature/Warranty.vue';
import Unit from '../pages/Feature/Unit.vue';
import Specification from '../pages/Feature/Specification.vue';
import SpecificationTable from '../pages/Feature/SpecificationTable.vue';
import Article from '../pages/Blog/Article.vue'
import Comment from '../pages/Blog/Comment.vue'
import Subject from '../pages/Blog/Subject.vue'
import Product from '../pages/Product/Product.vue'
import Label from '../pages/Product/Label.vue'
import ManageProduct from '../pages/Product/ManageProduct.vue'
import Category from '../pages/Product/Category.vue'
import Review from '../pages/Product/Review.vue'
import QuestionAndAnswer from '../pages/Product/QuestionAndAnswer.vue'
import OrderStatus from '../pages/Shop/OrderStatus.vue'
import ShippingMethod from '../pages/Shop/ShippingMethod.vue'
import Order from '../pages/Shop/Order.vue'
import Discount from '../pages/Shop/Discount.vue'
import ManageDiscount from '../pages/Shop/ManageDiscount.vue'
import OrderInfo from '../pages/Shop/OrderInfo'
import User from '../pages/User/User.vue'
import Role from '../pages/User/Role.vue'

const routes = [
  {
    path: "/panel",
    redirect: "/panel/product",
  },
  {
    path: "/panel",
    name: "dashboard",
    component: Dashboard,
    meta: { index: 0, auth: true },
  },
  {
    path: "/panel/brand",
    name: "مدیریت برند",
    component: Brand,
    meta: { index: '1', auth: true }
  },
  {
    path: "/panel/size",
    name: "مدیریت سایز",
    component: Size,
    meta: { index: '1', auth: true }
  },
  {
    path: "/panel/color",
    name: "مدیریت رنگ",
    component: Color,
    meta: { index: '1', auth: true }
  },
  {
    path: "/panel/warranty",
    name: "مدیریت گارانتی",
    component: Warranty,
    meta: { index: '1', auth: true }
  },
  {
    path: "/panel/unit",
    name: "مدیریت واحد",
    component: Unit,
    meta: { index: '1', auth: true }
  },
  {
    path: "/panel/specification",
    name: "مدیریت جداول مشخصات",
    component: Specification,
    meta: { index: '1', auth: true }
  },
  {
    path: "/panel/specification/:id",
    name: "مدیریت جدول مشخصات",
    component: SpecificationTable,
    meta: { index: '1', auth: true }
  },
  {
    path: "/panel/article",
    name: "مدیریت مقالات",
    component: Article,
    meta: { index: '2', auth: true }
  },
  {
    path: "/panel/comment",
    name: "مدیریت نظرات",
    component: Comment,
    meta: { index: '2', auth: true }
  },
  {
    path: "/panel/subject",
    name: "مدیریت موضوعات",
    component: Subject,
    meta: { index: '2', auth: true }
  },
  {
    path: "/panel/product",
    name: "مدیریت محصولات",
    component: Product,
    meta: { index: '3', auth: true }
  },
  {
    path: "/panel/label",
    name: "مدیریت لیبل محصولات",
    component: Label,
    meta: { index: '3', auth: true }
  },
  {
    path: "/panel/product/create",
    name: "ثبت محصول جدید",
    component: ManageProduct,
    meta: { index: '3', auth: true }
  },
  {
    path: "/panel/product/:id/edit",
    name: "ویرایش محصول",
    component: ManageProduct,
    meta: { index: '3', auth: true }
  },
  {
    path: "/panel/category",
    name: "مدیریت دسته بندی ها",
    component: Category,
    meta: { index: '3', auth: true }
  },
  {
    path: "/panel/review",
    name: "مدیریت نقد و بررسی ها",
    component: Review,
    meta: { index: '3', auth: true }
  },
  {
    path: "/panel/question_and_answer",
    name: "مدیریت پرسش و پاسخ ها",
    component: QuestionAndAnswer,
    meta: { index: '3', auth: true }
  },
  {
    path: "/panel/order_status",
    name: "مدیریت وضعیت های سفارش",
    component: OrderStatus,
    meta: { index: '4', auth: true }
  },
  {
    path: "/panel/shipping_method",
    name: "مدیریت روش های ارسال",
    component: ShippingMethod,
    meta: { index: '4', auth: true }
  },
  {
    path: "/panel/order",
    name: "مدیریت سفارشات",
    component: Order,
    meta: { index: '4', auth: true }
  },
  {
    path: "/panel/order/:id",
    name: "اطلاعات سفارش",
    component: OrderInfo,
    meta: { index: '4', auth: true }
  },
  {
    path: "/panel/discount",
    name: "مدیریت تخفیف ها",
    component: Discount,
    meta: { index: '4', auth: true }
  },
  {
    path: "/panel/discount/create",
    name: "ثبت تخفیف جدید",
    component: ManageDiscount,
    meta: { index: '4', auth: true }
  },
  {
    path: "/panel/discount/:id/edit",
    name: "ویرایش تخفیف",
    component: ManageDiscount,
    meta: { index: '4', auth: true }
  },
  {
    path: "/panel/user",
    name: "مدیریت کاربران",
    component: User,
    meta: { index: '5', auth: true }
  },
  {
    path: "/panel/role",
    name: "مدیریت نقش ها",
    component: Role,
    meta: { index: '5', auth: true }
  },
  {
    path: "/panel/setting/user",
    name: "تنظیمات کاربر",
    component: UserSetting,
    meta: { index: '6', auth: true }
  },
  {
    path: "/panel/setting/site",
    name: "تنظیمات سایت",
    component: SiteSetting,
    meta: { index: '6', auth: true }
  },
  { path: "*", component: NotFound },
];

/**
 * Asynchronously load view (Webpack Lazy loading compatible)
 * The specified component must be inside the Views folder
 * @param  {string} name  the filename (basename) of the view to load.
function view(name) {
   var res= require('../components/Dashboard/Views/' + name + '.vue');
   return res;
};**/

export default routes;
