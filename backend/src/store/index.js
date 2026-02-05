import { createStore }  from "vuex"
import * as actions from "./actions"
import * as mutations from "./mutations"
import state from "./state"
const store = createStore({
state,
getters: {},
actions,
mutations,

})

export default  store

// const { createStore } = require("vuex");

// const store = createStore({
//   state: {
//     count: 0
//   },
//   getters: {
//     doubleCount(state) {
//       return state.count * 2;
//     }
//   },
//   actions: {
//     increment(context) {
//       context.commit('increment');
//     }
//   },
//   mutations: {
//     increment(state) {
//       state.count++;
//     }
//   }
// });

// export default store;
// ما هو createStore؟
// createStore هو دالة في مكتبة Vuex تُستخدم لإنشاء مخزن (store) لإدارة الحالة في تطبيقات Vue.js. يساعد على تنظيم وإدارة الحالة المشتركة بين مكونات التطبيق بطريقة مركزية.

// كيفية عمل createStore
// عند إنشاء المخزن باستخدام createStore، يمكنك تحديد عدة خصائص:

// state:
// تمثل الحالة الأصلية للتطبيق. يمكنك تخزين البيانات هنا، مثل معلومات المستخدم أو قائمة المنتجات. تكون هذه البيانات تفاعلية، مما يعني أن أي تغييرات عليها ستؤدي إلى تحديث تلقائي للمكونات المعتمدة عليها.
// getters:
// تعتبر دوال تُستخدم لاستخراج بيانات معينة من الحالة. تعمل كخصائص محسوبة (computed properties) للمخزن، مما يسهل الوصول إلى البيانات المشتقة أو المعدلة.
// actions:
// هي دوال يمكن أن تحتوي على عمليات غير متزامنة (مثل استدعاءات API). تُستخدم لتنفيذ المهام التي قد تتطلب تغييرات في الحالة. يمكن أن تستدعي إجراءات أخرى أو تغييرات (mutations) لتحديث الحالة.
// mutations:
// دوال تُستخدم لتعديل الحالة بشكل مباشر. يجب أن تكون هذه التغييرات متزامنة، وتعتبر الطريقة الأساسية لتحديث الحالة في Vuex.
