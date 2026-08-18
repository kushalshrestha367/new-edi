(function(){
  'use strict';

  var pages = ['home','about','projects','contact','enquiry'];
  var titles = {
    home: 'EDI Homes — Building Your Future',
    about: 'About Us — EDI Homes',
    projects: 'Projects — EDI Homes',
    contact: 'Contact Us — EDI Homes',
    enquiry: 'Project Enquiry — EDI Homes'
  };

  var navLinks = document.querySelectorAll('nav.primary-nav a[data-link]');
  var menuToggle = document.getElementById('menuToggle');
  var primaryNav = document.getElementById('primaryNav');

  function currentPageFromHash(){
    var h = (window.location.hash || '#home').replace('#','');
    return pages.indexOf(h) !== -1 ? h : 'home';
  }

  function showPage(name){
    document.querySelectorAll('.page').forEach(function(sec){
      sec.classList.toggle('active', sec.id === name);
    });
    navLinks.forEach(function(link){
      link.classList.toggle('active', link.getAttribute('data-page') === name);
    });
    document.title = titles[name] || titles.home;
    window.scrollTo({ top: 0, behavior: 'auto' });
    initReveal();
  }

  function route(){
    showPage(currentPageFromHash());
  }

  window.addEventListener('hashchange', route);
  document.addEventListener('DOMContentLoaded', route);

  // Handle all data-link clicks (nav + in-page CTA buttons), close mobile menu
  document.querySelectorAll('a[data-link]').forEach(function(a){
    a.addEventListener('click', function(){
      primaryNav.classList.remove('open');
      menuToggle.classList.remove('open');
      menuToggle.setAttribute('aria-expanded','false');
    });
  });

  // Mobile menu toggle
  menuToggle.addEventListener('click', function(){
    var open = primaryNav.classList.toggle('open');
    menuToggle.classList.toggle('open', open);
    menuToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
  });

  // Scroll reveal
  var observer = null;
  function initReveal(){
    var els = document.querySelectorAll('.page.active .reveal:not(.in)');
    if(!('IntersectionObserver' in window)){
      els.forEach(function(el){ el.classList.add('in'); });
      return;
    }
    if(observer) observer.disconnect();
    observer = new IntersectionObserver(function(entries){
      entries.forEach(function(entry){
        if(entry.isIntersecting){
          entry.target.classList.add('in');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
    els.forEach(function(el){ observer.observe(el); });
  }

  // Project filter (Projects page) — combines category with min beds/baths/car
  var filterBtns = document.querySelectorAll('.filter-btn');
  var projectCards = document.querySelectorAll('#projectsGrid .project-card');
  var noResults = document.getElementById('noResults');
  var activeFilters = { category: 'all', beds: 0, baths: 0, car: 0 };

  function applyProjectFilters(){
    var visibleCount = 0;
    projectCards.forEach(function(card){
      var catMatch = activeFilters.category === 'all' || card.getAttribute('data-category') === activeFilters.category;
      var bedsMatch = Number(card.getAttribute('data-beds') || 0) >= activeFilters.beds;
      var bathsMatch = Number(card.getAttribute('data-baths') || 0) >= activeFilters.baths;
      var carMatch = Number(card.getAttribute('data-car') || 0) >= activeFilters.car;
      var match = catMatch && bedsMatch && bathsMatch && carMatch;
      card.style.display = match ? '' : 'none';
      if(match) visibleCount++;
    });
    if(noResults) noResults.style.display = visibleCount === 0 ? 'block' : 'none';
  }

  filterBtns.forEach(function(btn){
    btn.addEventListener('click', function(){
      filterBtns.forEach(function(b){ b.classList.remove('active'); });
      btn.classList.add('active');
      activeFilters = { category: btn.getAttribute('data-filter'), beds: 0, baths: 0, car: 0 };
      applyProjectFilters();
    });
  });

  // Home finder widget — sets filters, then hands off to the Projects page
  var finderForm = document.getElementById('finderForm');
  if(finderForm){
    finderForm.addEventListener('submit', function(e){
      e.preventDefault();
      var category = document.getElementById('f-type').value;
      var beds = Number(document.getElementById('f-beds').value);
      var baths = Number(document.getElementById('f-baths').value);
      var car = Number(document.getElementById('f-car').value);
      activeFilters = { category: category, beds: beds, baths: baths, car: car };
      filterBtns.forEach(function(b){ b.classList.toggle('active', b.getAttribute('data-filter') === category); });
      applyProjectFilters();
      window.location.hash = '#projects';
    });
  }

  // Form handling (front-end demo only — no backend connected yet)
  window.resetForm = function(formId, wrapId, successId){
    document.getElementById(formId).reset();
    document.getElementById(wrapId).style.display = '';
    document.getElementById(successId).classList.remove('show');
  };

  function bindForm(formId, wrapId, successId){
    var form = document.getElementById(formId);
    if(!form) return;
    form.addEventListener('submit', function(e){
      e.preventDefault();
      if(!form.checkValidity()){
        form.reportValidity();
        return;
      }
      document.getElementById(wrapId).style.display = 'none';
      document.getElementById(successId).classList.add('show');
    });
  }
  bindForm('contactForm','contactFormWrap','contactSuccess');
  bindForm('enquiryForm','enquiryFormWrap','enquirySuccess');

  // Footer year
  var yearEl = document.getElementById('year');
  if(yearEl) yearEl.textContent = new Date().getFullYear();

  // Initial route (in case DOMContentLoaded already fired)
  route();
})();
