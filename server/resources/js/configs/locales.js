import en from "../translations/en";
import es from "../translations/es";

const supported = ["en", "es"];
let locale = "en";

try {
 // get browser default language
 const { 0: browserLang } = navigator.language.split("-");

 if (supported.includes(browserLang)) locale = browserLang;
} catch (e) {
 console.log(e);
}

export default {
 // current locale
 locale,

 // when translation is not available fallback to that locale
 fallbackLocale: "en",

 // availabled locales for user selection
 availableLocales: [
  {
   code: "en",
   flag: "us",
   label: "English",
   messages: en
  },
  {
   code: "es",
   flag: "es",
   label: "Español",
   messages: es
  }
 ]
};
