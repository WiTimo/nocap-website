(function () {
  "use strict";

  var home = document.querySelector(".nocap-modern-home");
  if (!home) {
    return;
  }

  var supportsHover = window.matchMedia("(hover: hover)").matches;
  var STORAGE_KEY = "nocap-language";

  var i18n = {
    de: {
      "news_at_word": "am",
      "Home": "Home",
      "Über Uns": "Über Uns",
      "Über uns": "Über Uns",
      "Service & Preise": "Service & Preise",
      "Galerie": "Galerie",
      "Team": "Team",
      "FAQ": "FAQ",
      "Kontakt": "Kontakt",
      "Barber Shop 1010 Wien": "Barber Shop 1010 Wien",
      "NoCap Barber Shop": "NoCap Barber Shop",
      "Wir sind NoCap Barbers, der neue Barbershop im Herzen Wiens! Bei uns finden Sie professionelle und moderne Haar- und Bartschnitte.": "Wir sind NoCap Barbers, der neue Barbershop im Herzen Wiens! Bei uns finden Sie professionelle und moderne Haar- und Bartschnitte.",
      "Online Booking": "Online Booking",
      "Jetzt Termin sichern": "Jetzt Termin sichern",
      "3700+ Bewertungen": "3700+ Bewertungen",
      "Bewertet auf Google & Treatwell": "Bewertet auf Google & Treatwell",
      "Bewertungen": "Bewertungen",
      "4.9/5 Durchschnitt": "4.9/5 Durchschnitt",
      "3000+ Treatwell": "3000+ Treatwell",
      "700+ Google": "700+ Google",
      "Neu in 1010 Wien": "Neu in 1010 Wien",
      "Zweiter Shop kommt": "Zweiter Shop kommt",
      "Wir eröffnen bald am Bauernmarkt 10, 1010 Wien.": "Wir eröffnen bald am Bauernmarkt 10, 1010 Wien.",
      "Bauernmarkt 10, 1010 Wien": "Bauernmarkt 10, 1010 Wien",
      "Hoher Markt 3, 1010 Wien": "Hoher Markt 3, 1010 Wien",
      "1010 Wien": "1010 Wien",
      "Montag bis Samstag geöffnet": "Montag bis Samstag geöffnet",
      "Services": "Services",
      "Die wichtigsten Services auf einen Blick.": "Die wichtigsten Services auf einen Blick.",
      "Traditional Cut": "Traditional Cut",
      "Der traditionelle Haarschnitt": "Der traditionelle Haarschnitt",
      "Fade Cut": "Fade Cut",
      "Mit einem modernen Übergang": "Mit einem modernen Übergang",
      "Beard Service": "Beard Service",
      "Trimmen & Stylen nach Wunsch": "Trimmen & Stylen nach Wunsch",
      "Direkt zu Preisen, Services und Online-Buchung.": "Direkt zu Preisen, Services und Online-Buchung.",
      "Anspruch": "Anspruch",
      "\"Ich habe einen ganz einfachen Geschmack: Ich bin immer mit dem Besten zufrieden.\"": "\"Ich habe einen ganz einfachen Geschmack: Ich bin immer mit dem Besten zufrieden.\"",
      "Passt zu unserem Handwerk": "Passt zu unserem Handwerk",
      "Qualität ohne Theater.": "Qualität ohne Theater.",
      "Saubere Arbeit. Klares Finish.": "Saubere Arbeit. Klares Finish.",
      "Über Uns": "Über Uns",
      "NoCap Barbers steht für präzise Arbeit, ehrliche Beratung und eine Atmosphäre, die gleichzeitig entspannt und fokussiert ist.": "NoCap Barbers steht für präzise Arbeit, ehrliche Beratung und eine Atmosphäre, die gleichzeitig entspannt und fokussiert ist.",
      "Ein Barbershop mit Haltung": "Ein Barbershop mit Haltung",
      "Wir sind ein junges Team mit Energie, Blick fürs Detail und Respekt vor klassischem Handwerk.": "Wir sind ein junges Team mit Energie, Blick fürs Detail und Respekt vor klassischem Handwerk.",
      "Beratung, die tragbar bleibt": "Beratung, die tragbar bleibt",
      "Ein guter Look muss nicht nur im Shop, sondern auch im Alltag funktionieren.": "Ein guter Look muss nicht nur im Shop, sondern auch im Alltag funktionieren.",
      "Service ohne Showeffekte": "Service ohne Showeffekte",
      "Entspannte Stimmung, klare Kommunikation und ein Team, das lieber solide abliefert als sich hinter großen Worten versteckt.": "Entspannte Stimmung, klare Kommunikation und ein Team, das lieber solide abliefert als sich hinter großen Worten versteckt.",
      "Was bedeutet No Cap?": "Was bedeutet No Cap?",
      "Der Ausdruck steht für Ehrlichkeit. Keine Übertreibung, keine Fassade, kein unnötiger Lärm.": "Der Ausdruck steht für Ehrlichkeit. Keine Übertreibung, keine Fassade, kein unnötiger Lärm.",
      "Genau so verstehen wir unseren Shop: transparent in der Beratung, konsequent in der Qualität und aufmerksam in jedem Detail.": "Genau so verstehen wir unseren Shop: transparent in der Beratung, konsequent in der Qualität und aufmerksam in jedem Detail.",
      "Rezensionen": "Rezensionen",
      "3700+ Rezensionen": "3700+ Rezensionen",
      "3000+ Treatwell Reviews": "3000+ Treatwell Reviews",
      "700+ Google Reviews": "700+ Google Reviews",
      "Termin direkt online sichern und den nächsten Cut bei uns buchen.": "Termin direkt online sichern und den nächsten Cut bei uns buchen.",
      "Jetzt Termin buchen": "Jetzt Termin buchen",
      "Was Kunden über uns sagen": "Was Kunden über uns sagen",
      "Präzision": "Präzision",
      "Schnitt": "Schnitt",
      "Service": "Service",
      "Saubere Linien, sauberes Finish.": "Saubere Linien, sauberes Finish.",
      "Super Schnitt, super sauber, super nett!": "Super Schnitt, super sauber, super nett!",
      "Starker Schnitt beginnt mit Zuhören.": "Starker Schnitt beginnt mit Zuhören.",
      "A great barber doesn't just cut hair, they understand you.": "A great barber doesn't just cut hair, they understand you.",
      "Der Ton bleibt so gut wie das Ergebnis.": "Der Ton bleibt so gut wie das Ergebnis.",
      "Wie immer tolles Service und ein toller Haarschnitt.": "Wie immer tolles Service und ein toller Haarschnitt.",
      "Produkte, denen wir vertrauen": "Partner denen wir vertrauen",
      "Partner denen wir vertrauen": "Partner denen wir vertrauen",
      "Zwei Linien, zwei Stärken: Styling und Pflege.": "",
      "Mehr Clips auf TikTok": "Mehr Clips auf TikTok",
      "@nocap.barbershop": "@nocap.barbershop",
      "@nocap. barbershop": "@nocap. barbershop",
      "Tradition aus Rotterdam mit modernen Styling-Ergebnissen. Ideal für Pompadour, Textur oder kontrolliertes Volumen.": "Tradition aus Rotterdam mit modernen Styling-Ergebnissen. Ideal für Pompadour, Textur oder kontrolliertes Volumen.",
      "Clay, Pomade und Grooming Tonics": "Clay, Pomade und Grooming Tonics",
      "Starker Halt ohne steifes Finish": "Starker Halt ohne steifes Finish",
      "Ideal für strukturierte Styles": "Ideal für strukturierte Styles",
      "Pflege": "Pflege",
      "Pflege für Haare, Kopfhaut und Bart - entwickelt für saubere Routinen und lang haltbare Ergebnisse.": "Pflege für Haare, Kopfhaut und Bart - entwickelt für saubere Routinen und lang haltbare Ergebnisse.",
      "Shampoo, Scalp und Beard Care": "Shampoo, Scalp und Beard Care",
      "Sauberes, alltagstaugliches Pflege-System": "Sauberes, alltagstaugliches Pflege-System",
      "Für sensible Kopfhaut und definierte Bärte": "Für sensible Kopfhaut und definierte Bärte",
      "Rasur": "Rasur",
      "PRORASO": "PRORASO",
      "Italienische Barber-Klassiker für Rasur, Bart und Haut. Frisch, direkt und verlässlich, wenn Konturen sauber bleiben sollen.": "Italienische Barber-Klassiker für Rasur, Bart und Haut. Frisch, direkt und verlässlich, wenn Konturen sauber bleiben sollen.",
      "Pre-shave, Rasiercreme und Aftershave": "Pre-shave, Rasiercreme und Aftershave",
      "Starker Standard für saubere Konturen": "Starker Standard für saubere Konturen",
      "Bewährt für Bartpflege im Shop": "Bewährt für Bartpflege im Shop",
      "Textur": "Textur",
      "Volume + Matte": "Volume + Matte",
      "Slick Gorilla": "Slick Gorilla",
      "Moderne Texturprodukte für matte Looks mit Griff. Gut für lockere Styles, die leicht bleiben und trotzdem Form halten.": "Moderne Texturprodukte für matte Looks mit Griff. Gut für lockere Styles, die leicht bleiben und trotzdem Form halten.",
      "Styling Powder, Clay und Sea Salt Finish": "Styling Powder, Clay und Sea Salt Finish",
      "Volumen ohne schweres Produktgefühl": "Volumen ohne schweres Produktgefühl",
      "Ideal für messy, matte und natürliche Looks": "Ideal für messy, matte und natürliche Looks",
      "Blick in Shop, Schnitte und Stimmung.": "Blick in Shop, Schnitte und Stimmung.",
      "Mehr Cuts auf Instagram": "Mehr Cuts auf Instagram",
      "@nocap.barbers": "@nocap.barbers",
      "Dein nächster Termin": "Dein nächster Termin",
      "Jetzt online buchen": "Jetzt online buchen",
      "Barber, Geschäftsführer": "Barber, Geschäftsführer",
      "Dave war von Beginn an Teil von NoCap Barbers. Mit kreativen Ideen, sauberer Technik und echtem Servicegedanken hat er das Konzept mit aufgebaut und führt heute das Team mit klarer Qualitätsorientierung.": "Dave war von Beginn an Teil von NoCap Barbers. Mit kreativen Ideen, sauberer Technik und echtem Servicegedanken hat er das Konzept mit aufgebaut und führt heute das Team mit klarer Qualitätsorientierung.",
      "Steph verbindet sauberes Handwerk mit internationaler Erfahrung. Nach Stationen in verschiedenen Barbershops und einer Zeit in Kanada bringt er moderne und klassische Styles präzise auf den Punkt.": "Steph verbindet sauberes Handwerk mit internationaler Erfahrung. Nach Stationen in verschiedenen Barbershops und einer Zeit in Kanada bringt er moderne und klassische Styles präzise auf den Punkt.",
      "Nächster Cut": "Nächster Cut",
      "Termin sichern, Platz nehmen, frisch rausgehen.": "Termin sichern, Platz nehmen, frisch rausgehen.",
      "Buchen Sie Ihren Wunschtermin direkt online.": "Buchen Sie Ihren Wunschtermin direkt online.",
      "Jetzt buchen": "Jetzt buchen",
      "Barber Shop Wien: kurz beantwortet.": "Barber Shop Wien: kurz beantwortet.",
      "Wo ist NoCap Barbers in Wien?": "Wo ist NoCap Barbers in Wien?",
      "Sie finden uns am Hohen Markt 3 im 1. Bezirk, direkt im Zentrum von Wien.": "Sie finden uns am Hohen Markt 3 im 1. Bezirk, direkt im Zentrum von Wien.",
      "Kann ich online einen Termin buchen?": "Kann ich online einen Termin buchen?",
      "Ja. Termine für Haarschnitt, Fade Cut und Bartservice können direkt online über Treatwell gebucht werden.": "Ja. Termine für Haarschnitt, Fade Cut und Bartservice können direkt online über Treatwell gebucht werden.",
      "Welche Services bietet NoCap Barbers an?": "Welche Services bietet NoCap Barbers an?",
      "Unser Fokus liegt auf Traditional Cuts, Fade Cuts, Bartpflege, Styling und ehrlicher Beratung für Herren.": "Unser Fokus liegt auf Traditional Cuts, Fade Cuts, Bartpflege, Styling und ehrlicher Beratung für Herren.",
      "Öffnungszeiten": "Öffnungszeiten",
      "Montag - Mittwoch, Freitag": "Montag - Mittwoch, Freitag",
      "Donnerstag": "Donnerstag",
      "Samstag": "Samstag",
      "Feiertage": "Feiertage",
      "geschlossen": "geschlossen"
    },
    en: {
      "news_at_word": "at",
      "Home": "Home",
      "Über Uns": "About Us",
      "Über uns": "About Us",
      "Service & Preise": "Services & Prices",
      "Galerie": "Gallery",
      "Team": "Team",
      "FAQ": "FAQ",
      "Kontakt": "Contact",
      "Barber Shop 1010 Wien": "Barber Shop 1010 Vienna",
      "NoCap Barber Shop": "NoCap Barber Shop",
      "Wir sind NoCap Barbers, der neue Barbershop im Herzen Wiens! Bei uns finden Sie professionelle und moderne Haar- und Bartschnitte.": "We are NoCap Barbers, the new barbershop in the heart of Vienna. Here you get professional, modern haircuts and beard services.",
      "Online Booking": "Online Booking",
      "Jetzt Termin sichern": "Book your appointment",
      "3700+ Bewertungen": "3700+ reviews",
      "Bewertet auf Google & Treatwell": "Rated on Google & Treatwell",
      "Bewertungen": "reviews",
      "4.9/5 Durchschnitt": "4.9/5 average",
      "3000+ Treatwell": "3000+ Treatwell",
      "700+ Google": "700+ Google",
      "Neu in 1010 Wien": "New in 1010 Vienna",
      "Zweiter Shop kommt": "Second shop coming",
      "Wir eröffnen bald am Bauernmarkt 10, 1010 Wien.": "We are opening soon at Bauernmarkt 10, 1010 Vienna.",
      "Bauernmarkt 10, 1010 Wien": "Bauernmarkt 10, 1010 Vienna",
      "Hoher Markt 3, 1010 Wien": "Hoher Markt 3, 1010 Vienna",
      "1010 Wien": "1010 Vienna",
      "Montag bis Samstag geöffnet": "Open Monday to Saturday",
      "Services": "Services",
      "Die wichtigsten Services auf einen Blick.": "The most important services at a glance.",
      "Traditional Cut": "Traditional Cut",
      "Der traditionelle Haarschnitt": "The classic haircut",
      "Fade Cut": "Fade Cut",
      "Mit einem modernen Übergang": "With a modern fade",
      "Beard Service": "Beard Service",
      "Trimmen & Stylen nach Wunsch": "Trimmed and styled your way",
      "Direkt zu Preisen, Services und Online-Buchung.": "Go straight to prices, services and online booking.",
      "Anspruch": "Standard",
      "\"Ich habe einen ganz einfachen Geschmack: Ich bin immer mit dem Besten zufrieden.\"": "\"I have the simplest tastes. I am always satisfied with the best.\"",
      "Passt zu unserem Handwerk": "Fits our craft",
      "Qualität ohne Theater.": "Quality without theatre.",
      "Saubere Arbeit. Klares Finish.": "Clean work. Sharp finish.",
      "NoCap Barbers steht für präzise Arbeit, ehrliche Beratung und eine Atmosphäre, die gleichzeitig entspannt und fokussiert ist.": "NoCap Barbers stands for precise work, honest advice and an atmosphere that feels relaxed and focused at the same time.",
      "Ein Barbershop mit Haltung": "A barbershop with attitude",
      "Wir sind ein junges Team mit Energie, Blick fürs Detail und Respekt vor klassischem Handwerk.": "We are a young team with energy, an eye for detail and respect for classic craft.",
      "Beratung, die tragbar bleibt": "Advice that works in daily life",
      "Ein guter Look muss nicht nur im Shop, sondern auch im Alltag funktionieren.": "A good look has to work not only in the shop, but also in everyday life.",
      "Service ohne Showeffekte": "Service without empty show",
      "Entspannte Stimmung, klare Kommunikation und ein Team, das lieber solide abliefert als sich hinter großen Worten versteckt.": "Relaxed mood, clear communication and a team that prefers solid results over big words.",
      "Was bedeutet No Cap?": "What does No Cap mean?",
      "Der Ausdruck steht für Ehrlichkeit. Keine Übertreibung, keine Fassade, kein unnötiger Lärm.": "The phrase stands for honesty. No exaggeration, no facade, no unnecessary noise.",
      "Genau so verstehen wir unseren Shop: transparent in der Beratung, konsequent in der Qualität und aufmerksam in jedem Detail.": "That is how we understand our shop: transparent advice, consistent quality and attention in every detail.",
      "Rezensionen": "Reviews",
      "3700+ Rezensionen": "3700+ reviews",
      "3000+ Treatwell Reviews": "3000+ Treatwell reviews",
      "700+ Google Reviews": "700+ Google reviews",
      "Termin direkt online sichern und den nächsten Cut bei uns buchen.": "Book online and secure your next cut with us.",
      "Jetzt Termin buchen": "Book now",
      "Was Kunden über uns sagen": "What clients say about us",
      "Präzision": "Precision",
      "Schnitt": "Cut",
      "Service": "Service",
      "Saubere Linien, sauberes Finish.": "Clean lines, clean finish.",
      "Super Schnitt, super sauber, super nett!": "Great cut, super clean, super friendly!",
      "Starker Schnitt beginnt mit Zuhören.": "A strong cut starts with listening.",
      "A great barber doesn't just cut hair, they understand you.": "A great barber doesn't just cut hair, they understand you.",
      "Der Ton bleibt so gut wie das Ergebnis.": "The vibe is as good as the result.",
      "Wie immer tolles Service und ein toller Haarschnitt.": "As always, great service and a great haircut.",
      "Produkte, denen wir vertrauen": "Partners we trust",
      "Partner denen wir vertrauen": "Partners we trust",
      "Zwei Linien, zwei Stärken: Styling und Pflege.": "",
      "Mehr Clips auf TikTok": "More clips on TikTok",
      "@nocap.barbershop": "@nocap.barbershop",
      "@nocap. barbershop": "@nocap. barbershop",
      "Tradition aus Rotterdam mit modernen Styling-Ergebnissen. Ideal für Pompadour, Textur oder kontrolliertes Volumen.": "Tradition from Rotterdam with modern styling results. Ideal for pompadours, texture or controlled volume.",
      "Clay, Pomade und Grooming Tonics": "Clay, pomade and grooming tonics",
      "Starker Halt ohne steifes Finish": "Strong hold without a stiff finish",
      "Ideal für strukturierte Styles": "Ideal for textured styles",
      "Pflege": "Care",
      "Pflege für Haare, Kopfhaut und Bart - entwickelt für saubere Routinen und lang haltbare Ergebnisse.": "Care for hair, scalp and beard - made for clean routines and long-lasting results.",
      "Shampoo, Scalp und Beard Care": "Shampoo, scalp and beard care",
      "Sauberes, alltagstaugliches Pflege-System": "Clean care system for daily use",
      "Für sensible Kopfhaut und definierte Bärte": "For sensitive scalps and defined beards",
      "Rasur": "Shave",
      "PRORASO": "PRORASO",
      "Italienische Barber-Klassiker für Rasur, Bart und Haut. Frisch, direkt und verlässlich, wenn Konturen sauber bleiben sollen.": "Italian barber classics for shaving, beard and skin. Fresh, direct and reliable when contours need to stay clean.",
      "Pre-shave, Rasiercreme und Aftershave": "Pre-shave, shaving cream and aftershave",
      "Starker Standard für saubere Konturen": "Strong standard for clean contours",
      "Bewährt für Bartpflege im Shop": "Proven for beard care in the shop",
      "Textur": "Texture",
      "Volume + Matte": "Volume + Matte",
      "Slick Gorilla": "Slick Gorilla",
      "Moderne Texturprodukte für matte Looks mit Griff. Gut für lockere Styles, die leicht bleiben und trotzdem Form halten.": "Modern texture products for matte looks with grip. Good for loose styles that stay light while keeping shape.",
      "Styling Powder, Clay und Sea Salt Finish": "Styling powder, clay and sea salt finish",
      "Volumen ohne schweres Produktgefühl": "Volume without a heavy product feel",
      "Ideal für messy, matte und natürliche Looks": "Ideal for messy, matte and natural looks",
      "Blick in Shop, Schnitte und Stimmung.": "A look inside the shop, the cuts and the atmosphere.",
      "Mehr Cuts auf Instagram": "More cuts on Instagram",
      "@nocap.barbers": "@nocap.barbers",
      "Dein nächster Termin": "Your next appointment",
      "Jetzt online buchen": "Book online now",
      "Barber, Geschäftsführer": "Barber, Managing Director",
      "Dave war von Beginn an Teil von NoCap Barbers. Mit kreativen Ideen, sauberer Technik und echtem Servicegedanken hat er das Konzept mit aufgebaut und führt heute das Team mit klarer Qualitätsorientierung.": "Dave has been part of NoCap Barbers from the beginning. With creative ideas, clean technique and a real service mindset, he helped build the concept and now leads the team with a clear focus on quality.",
      "Steph verbindet sauberes Handwerk mit internationaler Erfahrung. Nach Stationen in verschiedenen Barbershops und einer Zeit in Kanada bringt er moderne und klassische Styles präzise auf den Punkt.": "Steph combines clean craft with international experience. After working in different barbershops and spending time in Canada, he brings modern and classic styles precisely to the point.",
      "Nächster Cut": "Next cut",
      "Termin sichern, Platz nehmen, frisch rausgehen.": "Book your slot, take a seat, leave fresh.",
      "Buchen Sie Ihren Wunschtermin direkt online.": "Book your preferred appointment directly online.",
      "Jetzt buchen": "Book now",
      "Barber Shop Wien: kurz beantwortet.": "Barber shop Vienna: quick answers.",
      "Wo ist NoCap Barbers in Wien?": "Where is NoCap Barbers in Vienna?",
      "Sie finden uns am Hohen Markt 3 im 1. Bezirk, direkt im Zentrum von Wien.": "You can find us at Hoher Markt 3 in Vienna's 1st district, right in the city centre.",
      "Kann ich online einen Termin buchen?": "Can I book an appointment online?",
      "Ja. Termine für Haarschnitt, Fade Cut und Bartservice können direkt online über Treatwell gebucht werden.": "Yes. Appointments for haircuts, fade cuts and beard services can be booked directly online via Treatwell.",
      "Welche Services bietet NoCap Barbers an?": "Which services does NoCap Barbers offer?",
      "Unser Fokus liegt auf Traditional Cuts, Fade Cuts, Bartpflege, Styling und ehrlicher Beratung für Herren.": "Our focus is traditional cuts, fade cuts, beard care, styling and honest advice for men.",
      "Öffnungszeiten": "Opening hours",
      "Montag - Mittwoch, Freitag": "Monday - Wednesday, Friday",
      "Donnerstag": "Thursday",
      "Samstag": "Saturday",
      "Feiertage": "Public holidays",
      "geschlossen": "closed"
    }
  };

  if (window.nocapHomeTranslations) {
    Object.keys(window.nocapHomeTranslations).forEach(function (language) {
      i18n[language] = Object.assign(i18n[language] || {}, window.nocapHomeTranslations[language]);
    });
  }

  var getStoredLanguage = function () {
    try {
      return window.localStorage ? window.localStorage.getItem(STORAGE_KEY) : "";
    } catch (error) {
      return "";
    }
  };

  var setStoredLanguage = function (language) {
    try {
      if (window.localStorage) {
        window.localStorage.setItem(STORAGE_KEY, language);
      }
    } catch (error) {
      return;
    }
  };

  var getInitialLanguage = function () {
    var stored = getStoredLanguage();
    if (stored === "de" || stored === "en" || stored === "ru" || stored === "uk") {
      return stored;
    }

    var browserLanguages = Array.isArray(navigator.languages) && navigator.languages.length
      ? navigator.languages
      : [navigator.language || ""];

    for (var index = 0; index < browserLanguages.length; index += 1) {
      var languageCode = String(browserLanguages[index] || "").toLowerCase().split("-")[0];
      if (languageCode === "ua") {
        languageCode = "uk";
      }
      if (languageCode === "de" || languageCode === "en" || languageCode === "ru" || languageCode === "uk") {
        return languageCode;
      }
    }

    return "en";
  };

  var translationLookup = {};
  Object.keys(i18n).forEach(function (language) {
    Object.keys(i18n[language]).forEach(function (key) {
      translationLookup[i18n[language][key]] = key;
      translationLookup[key] = key;
    });
  });

  var translatableNodes = [];
  var translatableNodeSet = typeof WeakSet !== "undefined" ? new WeakSet() : null;

  var normalizePrimaryNavigation = function () {
    var orders = [
      { id: "home", label: home.getAttribute("data-nav-home") || "Home" },
      { id: "service", label: home.getAttribute("data-nav-services") || "Service & Preise" },
      { id: "uber-uns", label: home.getAttribute("data-nav-about") || "Über Uns" },
      { id: "gallerie", label: home.getAttribute("data-nav-gallery") || "Galerie" },
      { id: "team", label: home.getAttribute("data-nav-team") || "Team" },
      { id: "faq", label: home.getAttribute("data-nav-faq") || "FAQ" },
      { id: "kontakt", label: home.getAttribute("data-nav-contact") || "Kontakt" }
    ];

    document.querySelectorAll("#top nav ul.sf-menu:not(.buttons), .off-canvas-menu-container ul.menu:not(.secondary-header-items)").forEach(function (menu) {
      menu.querySelectorAll(".nocap-menu-generated").forEach(function (item) {
        item.remove();
      });

      var social = menu.querySelector("#social-in-menu");
      var existingItems = Array.prototype.slice.call(menu.children).filter(function (item) {
        return item !== social;
      });
      var usedItems = [];
      var seenTargets = {};

      var findItem = function (config) {
        var found = null;
        existingItems.some(function (item) {
          if (usedItems.indexOf(item) > -1) {
            return false;
          }
          var link = item.querySelector("a");
          var text = link ? (link.textContent || "").trim() : "";
          var href = link ? link.getAttribute("href") || "" : "";
          var matches = href.indexOf("#" + config.id) > -1 || text === config.label || translationLookup[text] === config.label;
          if (config.id === "service") {
            matches = matches || /service|preise|prices|treatwell/i.test(text + href);
          }
          if (matches) {
            found = item;
            return true;
          }
          return false;
        });
        return found;
      };

      orders.forEach(function (config) {
        var item = findItem(config);
        if (!item) {
          item = document.createElement("li");
          item.className = "menu-item menu-item-type-custom menu-item-object-custom nocap-menu-generated";
          item.innerHTML = '<a href="#' + config.id + '">' + config.label + "</a>";
        }
        usedItems.push(item);

        var link = item.querySelector("a");
        if (link) {
          link.setAttribute("href", "#" + config.id);
          link.textContent = config.label;
          seenTargets["#" + config.id] = true;
        }
      });

      existingItems.forEach(function (item) {
        var link = item.querySelector("a");
        var href = link ? link.getAttribute("href") || "" : "";
        var isManaged = orders.some(function (config) {
          return href === "#" + config.id || href.indexOf("#" + config.id) > -1 || (config.id === "service" && /service|preise|prices|treatwell/i.test((link ? link.textContent : "") + href));
        });
        if (usedItems.indexOf(item) === -1 || isManaged || seenTargets[href]) {
          item.remove();
        }
      });

      usedItems.forEach(function (item) {
        menu.appendChild(item);
      });

      if (social) {
        menu.appendChild(social);
      }
    });
  };

  var rememberTranslatableText = function () {
    var selector = "h1,h2,h3,p,span,a,button,li,strong,blockquote";
    var scopedSelector = selector.split(",").map(function (item) {
      return ".nocap-modern-home " + item;
    }).join(",");
    var candidates = Array.prototype.slice.call(document.querySelectorAll(scopedSelector + ", #top nav a, .off-canvas-menu-container a"));

    candidates.forEach(function (node) {
      if (node.children.length || node.getAttribute("aria-hidden") === "true" || node.closest("[aria-hidden='true']") || node.closest(".nocap-lang-switcher") || node.closest(".nocap-social") || node.closest("#social-in-menu")) {
        return;
      }

      var text = (node.textContent || "").trim().replace(/\s+/g, " ");
      if (!text && !node.hasAttribute("data-nocap-i18n")) {
        return;
      }

      var key = node.getAttribute("data-nocap-i18n") || translationLookup[text];
      if (!key) {
        return;
      }

      node.setAttribute("data-nocap-i18n", key);
      if (!translatableNodeSet || !translatableNodeSet.has(node)) {
        translatableNodes.push(node);
        if (translatableNodeSet) {
          translatableNodeSet.add(node);
        }
      }
    });
  };

  var createLanguageSwitcher = function (extraClass) {
    var flagDe = home.getAttribute("data-flag-de") || "";
    var flagEn = home.getAttribute("data-flag-en") || "";
    var flagRu = home.getAttribute("data-flag-ru") || "";
    var flagUk = home.getAttribute("data-flag-uk") || "";
    var switcher = document.createElement("div");
    switcher.className = "nocap-lang-switcher" + (extraClass ? " " + extraClass : "");
    switcher.setAttribute("role", "group");
    switcher.setAttribute("aria-label", "Language");
    switcher.innerHTML =
      '<button type="button" data-nocap-lang="de" aria-label="Deutsch"><img src="' + flagDe + '" alt="">DE</button>' +
      '<button type="button" data-nocap-lang="en" aria-label="English"><img src="' + flagEn + '" alt="">EN</button>' +
      '<button type="button" data-nocap-lang="ru" aria-label="Русский"><img src="' + flagRu + '" alt="">RU</button>' +
      '<button type="button" data-nocap-lang="uk" aria-label="Українська"><img src="' + flagUk + '" alt="">UA</button>';

    var activeLanguage = home.getAttribute("data-current-language") || getInitialLanguage();
    switcher.querySelectorAll("[data-nocap-lang]").forEach(function (button) {
      var isActive = button.getAttribute("data-nocap-lang") === activeLanguage;
      button.classList.toggle("is-active", isActive);
      button.setAttribute("aria-pressed", isActive ? "true" : "false");
    });

    switcher.addEventListener("click", function (event) {
      var button = event.target.closest("[data-nocap-lang]");
      if (!button) {
        return;
      }
      var language = button.getAttribute("data-nocap-lang");
      setStoredLanguage(language);
      applyLanguage(language);
    });

    return switcher;
  };

  var buildLanguageSwitcher = function () {
    var mount = document.querySelector("[data-nocap-language-switcher]");
    if (mount && !mount.querySelector(".nocap-lang-switcher")) {
      mount.appendChild(createLanguageSwitcher("nocap-lang-switcher-hero"));
    }
  };

  var applyLanguage = function (language) {
    var strings = i18n[language] || i18n.en;
    document.documentElement.lang = language;
    home.setAttribute("data-current-language", language);

    document.querySelectorAll("[aria-hidden='true'] [data-nocap-i18n], [aria-hidden='true'][data-nocap-i18n]").forEach(function (node) {
      node.removeAttribute("data-nocap-i18n");
      if (node.closest(".nocap-review-proofline")) {
        node.textContent = "";
      }
    });

    rememberTranslatableText();

    translatableNodes.forEach(function (node) {
      var currentText = (node.textContent || "").trim().replace(/\s+/g, " ");
      var key = node.getAttribute("data-nocap-i18n") || translationLookup[currentText];

      if (key && Object.prototype.hasOwnProperty.call(strings, key)) {
        node.setAttribute("data-nocap-i18n", key);
        node.textContent = strings[key];
      }
    });

    document.querySelectorAll("[data-nocap-lang]").forEach(function (button) {
      var isActive = button.getAttribute("data-nocap-lang") === language;
      button.classList.toggle("is-active", isActive);
      button.setAttribute("aria-pressed", isActive ? "true" : "false");
    });
  };

  var initLanguage = function () {
    normalizePrimaryNavigation();
    rememberTranslatableText();
    buildLanguageSwitcher();
    applyLanguage(getInitialLanguage());
  };

  var initNavScrollSpy = function () {
    var sections = Array.prototype.slice.call(document.querySelectorAll(".nocap-modern-home section[id]"));
    var navLinks = Array.prototype.slice.call(document.querySelectorAll("#top nav a, .off-canvas-menu-container a")).filter(function (link) {
      var href = link.getAttribute("href") || "";
      return href.indexOf("#") === 0 || href.indexOf(window.location.origin + "/#") === 0 || href === window.location.origin + "/" || href === window.location.href.split("#")[0] + "/" || /treatwell|service|preise/i.test((link.textContent || "") + href);
    });

    if (!sections.length || !navLinks.length) {
      return;
    }

    navLinks.forEach(function (link) {
      link.removeAttribute("aria-current");
      if (link.parentElement) {
        link.parentElement.classList.remove("current-menu-item", "current_page_item", "current_page_parent", "current-menu-ancestor");
      }
    });

    var normalizeHref = function (link) {
      var href = link.getAttribute("href") || "";
      if (href.indexOf("#") > -1) {
        return href.slice(href.indexOf("#") + 1);
      }
      return "home";
    };

    var setActive = function (sectionId) {
      navLinks.forEach(function (link) {
        var id = normalizeHref(link);
        var isServiceBooking = sectionId === "service" && /treatwell|service|preise/i.test(link.textContent || link.href || "");
        var isActive = id === sectionId || isServiceBooking;
        link.classList.toggle("nocap-nav-active", isActive);
        link.parentElement && link.parentElement.classList.toggle("nocap-nav-active", isActive);
        if (isActive) {
          link.setAttribute("aria-current", "true");
        } else if (link.getAttribute("aria-current") === "true" || link.getAttribute("aria-current") === "page") {
          link.removeAttribute("aria-current");
        }
      });
    };

    var updateActiveSection = function () {
      var anchorLine = Math.max(120, window.innerHeight * 0.38);
      var current = "";

      sections.forEach(function (section) {
        var rect = section.getBoundingClientRect();
        if (rect.top <= anchorLine && rect.bottom > anchorLine) {
          current = section.id;
        }
      });

      setActive(current);
    };

    window.addEventListener("scroll", updateActiveSection, { passive: true });
    window.addEventListener("resize", updateActiveSection);
    updateActiveSection();
  };

  var bindArrowSwitch = function (buttons, onActivate) {
    buttons.forEach(function (button, index) {
      button.addEventListener("keydown", function (event) {
        var key = event.key;
        if (key !== "ArrowRight" && key !== "ArrowDown" && key !== "ArrowLeft" && key !== "ArrowUp") {
          return;
        }

        event.preventDefault();
        var direction = key === "ArrowRight" || key === "ArrowDown" ? 1 : -1;
        var nextIndex = (index + direction + buttons.length) % buttons.length;
        var nextButton = buttons[nextIndex];

        nextButton.focus();
        onActivate(nextButton);
      });
    });
  };

  var initReviewSwitch = function () {
    var tabs = Array.prototype.slice.call(document.querySelectorAll("[data-review-tab]"));
    var panels = Array.prototype.slice.call(document.querySelectorAll("[data-review-panel]"));

    if (!tabs.length || !panels.length) {
      return;
    }

    var activateTab = function (tab) {
      var target = tab.getAttribute("data-review-tab");

      tabs.forEach(function (item) {
        var isActive = item === tab;
        item.classList.toggle("is-active", isActive);
        item.setAttribute("aria-selected", isActive ? "true" : "false");
        item.setAttribute("tabindex", isActive ? "0" : "-1");
      });

      panels.forEach(function (panel) {
        var isActive = panel.getAttribute("data-review-panel") === target;
        panel.classList.toggle("is-active", isActive);
        panel.setAttribute("aria-hidden", isActive ? "false" : "true");
      });
    };

    tabs.forEach(function (tab) {
      tab.addEventListener("click", function () {
        activateTab(tab);
      });

      tab.addEventListener("focus", function () {
        activateTab(tab);
      });

      if (supportsHover) {
        tab.addEventListener("mouseenter", function () {
          activateTab(tab);
        });
      }
    });

    bindArrowSwitch(tabs, activateTab);

    var currentTab = document.querySelector(".nocap-review-chip.is-active") || tabs[0];
    activateTab(currentTab);
  };

  var initProductSwitch = function () {
    var stage = document.querySelector("[data-product-stage]");
    var stageName = stage ? stage.querySelector("[data-product-stage-name]") : null;
    var stageTag = stage ? stage.querySelector("[data-product-stage-tag]") : null;
    var stageDescription = stage ? stage.querySelector("[data-product-stage-description]") : null;
    var buttons = Array.prototype.slice.call(document.querySelectorAll("[data-product-button]"));

    if (!stage || !stageName || !stageTag || !stageDescription || !buttons.length) {
      return;
    }

    var activateProduct = function (button) {
      var image = button.getAttribute("data-product-image") || "";
      var name = button.getAttribute("data-product-name") || "";
      var tag = button.getAttribute("data-product-tag") || "";
      var description = button.getAttribute("data-product-description") || "";

      buttons.forEach(function (item) {
        var isActive = item === button;
        item.classList.toggle("is-active", isActive);
        item.setAttribute("aria-selected", isActive ? "true" : "false");
        item.setAttribute("tabindex", isActive ? "0" : "-1");
      });

      if (image) {
        stage.style.setProperty("--active-image", "url(" + image + ")");
      }

      stageName.textContent = name;
      stageTag.textContent = tag;
      stageDescription.textContent = description;
    };

    buttons.forEach(function (button) {
      button.addEventListener("click", function () {
        activateProduct(button);
      });

      button.addEventListener("focus", function () {
        activateProduct(button);
      });

      if (supportsHover) {
        button.addEventListener("mouseenter", function () {
          activateProduct(button);
        });
      }
    });

    bindArrowSwitch(buttons, activateProduct);

    var currentButton = document.querySelector(".nocap-product-track.is-active") || buttons[0];
    activateProduct(currentButton);
  };

  initReviewSwitch();
  initProductSwitch();
  initLanguage();
  initNavScrollSpy();

  var initHeroSound = function () {
    var soundUrl = home.getAttribute("data-scissors-sound") || "";
    if (!soundUrl) {
      return;
    }

    var audio = new Audio(soundUrl);
    var configuredVolume = parseFloat(home.getAttribute("data-scissors-volume") || "0.02");
    var maxVolume = Number.isFinite(configuredVolume) ? Math.max(0, Math.min(1, configuredVolume)) : 0.02;
    var started = false;
    var finished = false;
    var fadeFrame = 0;
    var fadeOutTimer = 0;
    var metadataFallbackTimer = 0;
    var fadeInMs = 260;
    var fadeOutMs = 520;
    var fallbackDurationMs = 1600;
    audio.loop = false;
    audio.preload = "auto";
    audio.volume = 0;

    var cleanupStartListeners = function () {
      ["pointerdown", "touchstart", "keydown"].forEach(function (eventName) {
        document.removeEventListener(eventName, startAudio);
      });
    };

    var fadeTo = function (targetVolume, duration, onComplete) {
      var startVolume = audio.volume;
      var startTime = window.performance ? window.performance.now() : Date.now();

      if (fadeFrame) {
        window.cancelAnimationFrame(fadeFrame);
      }

      var step = function (now) {
        var progress = Math.min(1, (now - startTime) / duration);
        audio.volume = startVolume + ((targetVolume - startVolume) * progress);

        if (progress < 1) {
          fadeFrame = window.requestAnimationFrame(step);
          return;
        }

        fadeFrame = 0;
        audio.volume = targetVolume;
        if (onComplete) {
          onComplete();
        }
      };

      fadeFrame = window.requestAnimationFrame(step);
    };

    var fadeOutAndStop = function () {
      if (finished) {
        return;
      }
      finished = true;
      fadeTo(0, fadeOutMs, function () {
        audio.pause();
        audio.currentTime = 0;
      });
    };

    var scheduleFadeOut = function () {
      window.clearTimeout(metadataFallbackTimer);
      window.clearTimeout(fadeOutTimer);
      var durationMs = Number.isFinite(audio.duration) && audio.duration > 0 ? audio.duration * 1000 : fallbackDurationMs;
      var delay = Math.max(fadeInMs, durationMs - fadeOutMs);
      fadeOutTimer = window.setTimeout(fadeOutAndStop, delay);
    };

    var startAudio = function () {
      if (started || finished) {
        return;
      }

      audio.play().then(function () {
        started = true;
        cleanupStartListeners();
        fadeTo(maxVolume, fadeInMs);
        if (audio.readyState >= 1) {
          scheduleFadeOut();
        } else {
          audio.addEventListener("loadedmetadata", scheduleFadeOut, { once: true });
          metadataFallbackTimer = window.setTimeout(fadeOutAndStop, fallbackDurationMs);
        }
      }).catch(function () {
        started = false;
      });
    };

    ["pointerdown", "touchstart", "keydown"].forEach(function (eventName) {
      document.addEventListener(eventName, startAudio, { passive: true });
    });

    audio.addEventListener("ended", fadeOutAndStop, { once: true });
    document.addEventListener("visibilitychange", function () {
      if (!document.hidden || !started || finished) {
        return;
      }
      window.clearTimeout(metadataFallbackTimer);
      window.clearTimeout(fadeOutTimer);
      fadeOutAndStop();
    });
    startAudio();
  };

  initHeroSound();

  var reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
  var revealNodes = document.querySelectorAll("[data-reveal]");
  var revealStyles = ["lift", "slide-left", "tilt", "scale"];

  home.classList.add("is-reveal-ready");

  revealNodes.forEach(function (node, index) {
    var delay = node.style.getPropertyValue("--reveal-delay");
    if (delay && delay.indexOf("s") !== -1) {
      var delaySeconds = parseFloat(delay);
      if (!Number.isNaN(delaySeconds)) {
        node.style.setProperty("--reveal-delay", Math.min(delaySeconds * 0.65, 0.22).toFixed(3) + "s");
      }
    }

    if (node.hasAttribute("data-reveal-style")) {
      return;
    }

    if (node.closest(".nocap-hero")) {
      node.setAttribute("data-reveal-style", "hero");
      return;
    }

    if (node.matches(".nocap-section-title, h2, h3")) {
      node.setAttribute("data-reveal-style", "slide-left");
      return;
    }

    if (node.querySelector("img, video, iframe") || node.matches(".nocap-map, .nocap-quote-stage, .nocap-product-media")) {
      node.setAttribute("data-reveal-style", index % 2 ? "tilt" : "scale");
      return;
    }

    node.setAttribute("data-reveal-style", revealStyles[index % revealStyles.length]);
  });

  if (reduceMotion || typeof IntersectionObserver === "undefined") {
    document.body.classList.add("nocap-reduced-motion");
    revealNodes.forEach(function (node) {
      node.classList.add("is-visible");
    });
  } else {
    var revealObserver = new IntersectionObserver(
      function (entries, observer) {
        entries.forEach(function (entry) {
          if (!entry.isIntersecting) {
            return;
          }
          entry.target.classList.add("is-visible");
          observer.unobserve(entry.target);
        });
      },
      {
        threshold: 0.08,
        rootMargin: "0px 0px -4% 0px"
      }
    );

    revealNodes.forEach(function (node) {
      revealObserver.observe(node);
    });
  }

  var heroMedia = document.querySelector(".nocap-hero-media");
  if (!heroMedia) {
    return;
  }

  var ticking = false;
  var heroVideos = Array.prototype.slice.call(document.querySelectorAll(".nocap-hero-video"));

  if (heroVideos.length > 1) {
    heroVideos[0].addEventListener("play", function () {
      heroVideos.slice(1).forEach(function (video) {
        if (Math.abs(video.currentTime - heroVideos[0].currentTime) > 0.18) {
          video.currentTime = heroVideos[0].currentTime;
        }
      });
    });
  }

  var updateParallax = function () {
    var rect = heroMedia.getBoundingClientRect();
    var vh = window.innerHeight || document.documentElement.clientHeight;

    if (rect.bottom <= 0 || rect.top >= vh) {
      ticking = false;
      return;
    }

    var progress = (vh - rect.top) / (vh + rect.height);
    var shift = Math.max(-12, Math.min(12, (progress - 0.5) * 24));

    heroMedia.style.transform = "translateY(" + shift.toFixed(2) + "px)";
    ticking = false;
  };

  var requestUpdate = function () {
    if (ticking) {
      return;
    }
    ticking = true;
    window.requestAnimationFrame(updateParallax);
  };

  window.addEventListener("scroll", requestUpdate, { passive: true });
  window.addEventListener("resize", requestUpdate);
  requestUpdate();

  var scrollLockY = 0;
  var isMenuOpen = function () {
    return document.body.classList.contains("mobile-active") ||
      document.body.classList.contains("mobile-menu-overlay-active") ||
      document.body.classList.contains("material-ocm-open") ||
      document.body.classList.contains("ascend-mobile-menu-open") ||
      document.body.classList.contains("ocm-effect-wrap-open") ||
      document.documentElement.classList.contains("mobile-menu-open") ||
      document.documentElement.classList.contains("material-ocm-open") ||
      !!document.querySelector(".off-canvas-menu-container.open, .off-canvas-menu-container.active, .off-canvas-menu-container.menu-open, .off-canvas-menu-container[data-nectar-ocm-state='open'], .slide-out-widget-area.open, .slide-out-widget-area.material-open");
  };
  var syncMobileMenuLock = function () {
    var shouldLock = isMenuOpen();
    if (shouldLock && !document.body.classList.contains("nocap-mobile-menu-locked")) {
      scrollLockY = window.pageYOffset || document.documentElement.scrollTop || 0;
      document.body.style.setProperty("--nocap-lock-top", "-" + scrollLockY + "px");
      document.body.classList.add("nocap-mobile-menu-locked");
      document.documentElement.classList.add("nocap-mobile-menu-locked");
    } else if (!shouldLock && document.body.classList.contains("nocap-mobile-menu-locked")) {
      document.body.classList.remove("nocap-mobile-menu-locked");
      document.documentElement.classList.remove("nocap-mobile-menu-locked");
      document.body.style.removeProperty("--nocap-lock-top");
      window.scrollTo(0, scrollLockY);
    }
  };
  if (typeof MutationObserver !== "undefined") {
    var menuLockObserver = new MutationObserver(syncMobileMenuLock);
    menuLockObserver.observe(document.documentElement, { attributes: true, attributeFilter: ["class"] });
    menuLockObserver.observe(document.body, { attributes: true, attributeFilter: ["class"] });
    document.querySelectorAll(".off-canvas-menu-container").forEach(function (menu) {
      menuLockObserver.observe(menu, { attributes: true, attributeFilter: ["class", "data-nectar-ocm-state"] });
    });
  }
  window.setInterval(syncMobileMenuLock, 250);
  syncMobileMenuLock();

})();
