import{K as w,L as v,H as x,m as p,o as h,e as b,f as o,w as l,p as n,g as a,x as c,B as i,n as g,A as k,l as B,M as C}from"./vendor-D0uUw6YD.js";const E={class:"fixed inset-0 z-50 overflow-y-auto px-4 py-6 sm:px-0","scroll-region":""},M={__name:"Modal",props:{show:{type:Boolean,default:!1},maxWidth:{type:String,default:"2xl"},closeable:{type:Boolean,default:!0}},emits:["close"],setup(e,{emit:u}){const s=e,y=u;w(()=>s.show,()=>{s.show?document.body.style.overflow="hidden":document.body.style.overflow=null});const r=()=>{s.closeable&&y("close")},m=t=>{t.key==="Escape"&&s.show&&r()};v(()=>document.addEventListener("keydown",m)),x(()=>{document.removeEventListener("keydown",m),document.body.style.overflow=null});const f=p(()=>({sm:"sm:max-w-sm",md:"sm:max-w-md",lg:"sm:max-w-lg",xl:"sm:max-w-xl","2xl":"sm:max-w-2xl"})[s.maxWidth]);return(t,d)=>(h(),b(C,{to:"body"},[o(c,{"leave-active-class":"duration-200"},{default:l(()=>[n(a("div",E,[o(c,{"enter-active-class":"ease-out duration-300","enter-from-class":"opacity-0","enter-to-class":"opacity-100","leave-active-class":"ease-in duration-200","leave-from-class":"opacity-100","leave-to-class":"opacity-0"},{default:l(()=>[n(a("div",{class:"fixed inset-0 transform transition-all",onClick:r},d[0]||(d[0]=[a("div",{class:"absolute inset-0 bg-gray-500 opacity-75"},null,-1)]),512),[[i,e.show]])]),_:1}),o(c,{"enter-active-class":"ease-out duration-300","enter-from-class":"opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95","enter-to-class":"opacity-100 translate-y-0 sm:scale-100","leave-active-class":"ease-in duration-200","leave-from-class":"opacity-100 translate-y-0 sm:scale-100","leave-to-class":"opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"},{default:l(()=>[n(a("div",{class:g(["mb-6 transform overflow-hidden rounded-lg bg-white shadow-xl transition-all sm:mx-auto sm:w-full",f.value])},[e.show?k(t.$slots,"default",{key:0}):B("",!0)],2),[[i,e.show]])]),_:3})],512),[[i,e.show]])]),_:3})]))}};export{M as _};
