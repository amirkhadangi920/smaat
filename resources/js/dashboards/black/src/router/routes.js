import DashboardLayout from "../layout/dashboard/DashboardLayout.vue";
// GeneralViews
import NotFound from "../pages/NotFoundPage.vue";

// Admin pages
import Dashboard from "../pages/Dashboard.vue";
import Profile from "../pages/Profile.vue";
import Notifications from "../pages/Notifications.vue";
import Icons from "../pages/Icons.vue";
import Maps from "../pages/Maps.vue";
import Typography from "../pages/Typography.vue";
import TableList from "../pages/TableList.vue";
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
import Category from '../pages/Product/Category.vue'
import Review from '../pages/Product/Review.vue'
import QuestionAndAnswer from '../pages/Product/QuestionAndAnswer.vue'
import OrderStatus from '../pages/Shop/OrderStatus.vue'
import ShippingMethod from '../pages/Shop/ShippingMethod.vue'
import Order from '../pages/Shop/Order.vue'

import Login from '../pages/Login'

const routes = [
  {
    path: "/",
    component: DashboardLayout,
    redirect: "/dashboard",
    children: [
      {
        path: "dashboard",
        name: "dashboard",
        component: Dashboard,
        meta: { auth: true },
      },
      {
        path: "profile",
        name: "profile",
        component: Profile
      },
      {
        path: "notifications",
        name: "notifications",
        component: Notifications
      },
      {
        path: "icons",
        name: "icons",
        component: Icons
      },
      {
        path: "maps",
        name: "maps",
        component: Maps
      },
      {
        path: "typography",
        name: "typography",
        component: Typography
      },
      {
        path: "table-list",
        name: "table-list",
        component: TableList
      },
      {
        path: "brand",
        name: "مدیریت برند",
        component: Brand,
        meta: { index: '1', auth: true }
      },
      {
        path: "size",
        name: "مدیریت سایز",
        component: Size,
        meta: { index: '1', auth: true }
      },
      {
        path: "color",
        name: "مدیریت رنگ",
        component: Color,
        meta: { index: '1', auth: true }
      },
      {
        path: "warranty",
        name: "مدیریت گارانتی",
        component: Warranty,
        meta: { index: '1', auth: true }
      },
      {
        path: "unit",
        name: "مدیریت واحد",
        component: Unit,
        meta: { index: '1', auth: true }
      },
      {
        path: "specification",
        name: "مدیریت جداول مشخصات",
        component: Specification,
        meta: { index: '1', auth: true }
      },
      {
        path: "specification/:id",
        name: "مدیریت جدول مشخصات",
        component: SpecificationTable,
        meta: { index: '1', auth: true }
      },
      {
        path: "article",
        name: "مدیریت مقالات",
        component: Article,
        meta: { index: '2', auth: true }
      },
      {
        path: "comment",
        name: "مدیریت نظرات",
        component: Comment,
        meta: { index: '2', auth: true }
      },
      {
        path: "subject",
        name: "مدیریت موضوعات",
        component: Subject,
        meta: { index: '2', auth: true }
      },
      {
        path: "product",
        name: "مدیریت محصولات",
        component: Product,
        meta: { index: '3', auth: true }
      },
      {
        path: "category",
        name: "مدیریت دسته بندی ها",
        component: Category,
        meta: { index: '3', auth: true }
      },
      {
        path: "review",
        name: "مدیریت نقد و بررسی ها",
        component: Review,
        meta: { index: '3', auth: true }
      },
      {
        path: "question_and_answer",
        name: "مدیریت پرسش و پاسخ ها",
        component: QuestionAndAnswer,
        meta: { index: '3', auth: true }
      },
      {
        path: "order_status",
        name: "مدیریت وضعیت های سفارش",
        component: OrderStatus,
        meta: { index: '4', auth: true }
      },
      {
        path: "shipping_method",
        name: "مدیریت روش های ارسال",
        component: ShippingMethod,
        meta: { index: '4', auth: true }
      },
      {
        path: "order",
        name: "مدیریت سفارشات",
        component: Order,
        meta: { index: '4', auth: true }
      }
    ]
  },
  {
    path: "/login",
    component: Login
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
