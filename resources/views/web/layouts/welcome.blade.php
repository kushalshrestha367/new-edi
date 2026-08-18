@extends('web.layouts.app')

@section('content')
 <section id="home" class="page">

    <!-- HERO -->
    <div class="hero">
      <div class="container hero-grid">
        <div class="reveal in">
          <span class="eyebrow">Residential &amp; Commercial Construction</span>
          <h1>Building <em>your future,</em> one considered home at a time.</h1>
          <p class="hero-sub">EDI Homes plans, designs and builds homes that are made to last — guiding clients from first sketch through to final handover with a steady, detail-first approach.</p>
          <div class="hero-actions">
            <a href="#enquiry" data-link class="btn btn-primary">Start an enquiry</a>
            <a href="#projects" data-link class="btn btn-ghost">View our projects</a>
          </div>
          <div class="hero-trust">
            <div><strong>[12]<span style="color:var(--amber)">+</span></strong><span>Years building</span></div>
            <div><strong>[80]<span style="color:var(--amber)">+</span></strong><span>Homes delivered</span></div>
            <div><strong>[98]<span style="color:var(--amber)">%</span></strong><span>Client satisfaction</span></div>
          </div>
        </div>

        <div class="hero-art" aria-hidden="true">
          <svg viewBox="0 0 400 400" fill="none">
            <!-- roof -->
            <path class="draw" d="M60 190 L200 70 L340 190" />
            <!-- house body -->
            <path class="draw draw-accent" d="M95 190 L95 330 L305 330 L305 190" />
            <!-- door -->
            <path class="draw draw-amber" d="M175 330 L175 250 L225 250 L225 330" />
            <!-- window left -->
            <path class="draw" d="M120 220 L155 220 L155 255 L120 255 Z" />
            <!-- window right -->
            <path class="draw" d="M245 220 L280 220 L280 255 L245 255 Z" />
            <!-- ridge dot -->
            <circle class="fill-dot" cx="200" cy="70" r="5" />
            <!-- dimension line -->
            <line class="draw" x1="60" y1="352" x2="340" y2="352" stroke-width="1.4" />
            <line class="draw" x1="60" y1="345" x2="60" y2="359" stroke-width="1.4" />
            <line class="draw" x1="340" y1="345" x2="340" y2="359" stroke-width="1.4" />
            <text class="tick-label" x="175" y="374">9.4M SPAN</text>
          </svg>
        </div>
      </div>
    </div>

    <!-- HOME FINDER -->
    <div class="container">
      <div class="home-finder reveal in">
        <div class="finder-card">
          <div class="finder-head">
            <h3>Find your next project</h3>
            <span>Filters by design type, beds, baths &amp; car spaces</span>
          </div>
          <form id="finderForm" class="finder-grid">
            <div class="finder-field">
              <label for="f-type">Design range</label>
              <select id="f-type">
                <option value="all">Any</option>
                <option value="residential">Residential</option>
                <option value="renovation">Renovation</option>
                <option value="commercial">Commercial</option>
              </select>
            </div>
            <div class="finder-field">
              <label for="f-beds">Beds</label>
              <select id="f-beds">
                <option value="0">Any</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5+</option>
              </select>
            </div>
            <div class="finder-field">
              <label for="f-baths">Baths</label>
              <select id="f-baths">
                <option value="0">Any</option>
                <option value="2">2</option>
                <option value="3">3+</option>
              </select>
            </div>
            <div class="finder-field">
              <label for="f-car">Car spaces</label>
              <select id="f-car">
                <option value="0">Any</option>
                <option value="1">1</option>
                <option value="2">2+</option>
              </select>
            </div>
            <button type="submit" class="finder-submit">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/></svg>
              Find a Home
            </button>
          </form>
        </div>
      </div>
    </div>

    <!-- STATS STRIP -->
    <div class="stats-strip">
      <div class="container stats-grid">
        <div class="stat-item reveal">
          <div class="num">[12]<span class="unit">yrs</span></div>
          <div class="label">In operation</div>
        </div>
        <div class="stat-item reveal">
          <div class="num">[80]<span class="unit">+</span></div>
          <div class="label">Projects completed</div>
        </div>
        <div class="stat-item reveal">
          <div class="num">[98]<span class="unit">%</span></div>
          <div class="label">On-time handover</div>
        </div>
        <div class="stat-item reveal">
          <div class="num">[15]<span class="unit">+</span></div>
          <div class="label">Trusted trades &amp; partners</div>
        </div>
      </div>
    </div>

    <!-- SERVICES -->
    <div class="section">
      <div class="container">
        <div class="section-head reveal">
          <span class="eyebrow">What we do</span>
          <h2>Every stage of the build, under one roof.</h2>
          <p>From the first concept sketch to the final coat of paint, our team stays close to the project so nothing gets lost between trades.</p>
        </div>
        <div class="services-grid">
          <div class="service-card reveal">
            <div class="service-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 11.5 12 4l9 7.5"/><path d="M5.5 10v9.5h13V10"/><path d="M10 19.5v-6h4v6"/></svg>
            </div>
            <h3>New Home Builds</h3>
            <p>Custom residential builds designed around how you actually live, from single-storey homes to multi-level dwellings.</p>
          </div>
          <div class="service-card reveal">
            <div class="service-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 3.5 20.5 9.5 9 21H3v-6z"/><path d="M13 5l6 6"/></svg>
            </div>
            <h3>Renovations &amp; Extensions</h3>
            <p>Thoughtful upgrades and additions that respect your existing home while giving you the space you need.</p>
          </div>
          <div class="service-card reveal">
            <div class="service-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="7" r="3.2"/><path d="M8.8 9.5 4.5 20h5"/><path d="M15.2 9.5 19.5 20h-5"/></svg>
            </div>
            <h3>Design &amp; Planning</h3>
            <p>Concept drawings, council documentation and engineering coordination handled before a single brick is laid.</p>
          </div>
          <div class="service-card reveal">
            <div class="service-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="4" width="14" height="17" rx="1.5"/><path d="M9 3.5h6v2H9z"/><path d="M8.5 11h7M8.5 14.5h7M8.5 18h4"/></svg>
            </div>
            <h3>Project Management</h3>
            <p>One point of contact from permits to practical completion, keeping trades, timelines and budgets on track.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- WHY CHOOSE US -->
    <div class="section section-alt">
      <div class="container why-grid">
        <div class="reveal">
          <span class="eyebrow">Why choose us</span>
          <h2>Straightforward building, from a team that shows up.</h2>
          <p>No surprise costs, no disappearing site managers. Just a clear plan and a crew that sticks to it.</p>
          <div class="why-list">
            <div class="why-item">
              <div class="service-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19V6.5A2.5 2.5 0 0 1 6.5 4H18a1 1 0 0 1 1 1v13"/><path d="M4 19a2 2 0 0 0 2 2h13"/><path d="M8 8h7M8 11.5h7"/></svg></div>
              <div><h3>Fixed-price contracts</h3><p>Your quote is your quote — no unexplained cost blowouts after signing.</p></div>
            </div>
            <div class="why-item">
              <div class="service-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="3.2"/><path d="M5 20c1-3.5 4-5.5 7-5.5S19 16.5 20 20"/></svg></div>
              <div><h3>One dedicated site manager</h3><p>A single point of contact who knows your project end to end.</p></div>
            </div>
            <div class="why-item">
              <div class="service-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M5 13l4 4L19 7"/></svg></div>
              <div><h3>Checked at every stage</h3><p>Independent quality checks at each build milestone, not just at handover.</p></div>
            </div>
          </div>
        </div>
        <div class="ph-media reveal">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 11.5 12 4l9 7.5"/><path d="M5.5 10v9.5h13V10"/></svg>
          <span class="ph-label">Site or team photo — add image</span>
        </div>
      </div>
    </div>

    <!-- FEATURED PROJECTS -->
    <div class="section section-alt">
      <div class="container">
        <div class="section-head reveal">
          <span class="eyebrow">Recent work</span>
          <h2>A few homes we've delivered.</h2>
          <p>A small selection of recent builds — visit the Projects page for the full portfolio.</p>
        </div>
        <div class="projects-grid">
          <div class="project-card reveal">
            <div class="ph-media">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 11.5 12 4l9 7.5"/><path d="M5.5 10v9.5h13V10"/></svg>
              <span class="ph-label">Project photo — add image</span>
            </div>
            <div class="project-body">
              <span class="project-tag">Residential</span>
              <h3>[Project Name]</h3>
              <div class="project-loc">[Suburb, State]</div>
              <div class="spec-row">
                <span class="spec-chip"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 20v-7a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v7"/><path d="M3 13V9a2 2 0 0 1 2-2h3v4"/><path d="M3 20h18"/></svg>[4] Bed</span>
                <span class="spec-chip"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 12h16M5 12V6a2 2 0 0 1 2-2h2v3M5 20v-4M19 20v-4"/></svg>[2] Bath</span>
                <span class="spec-chip"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="4" y="4" width="16" height="16"/></svg>[210]m²</span>
              </div>
              <p>Short one-line description of the build, materials or standout feature goes here.</p>
            </div>
          </div>
          <div class="project-card reveal">
            <div class="ph-media">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 11.5 12 4l9 7.5"/><path d="M5.5 10v9.5h13V10"/></svg>
              <span class="ph-label">Project photo — add image</span>
            </div>
            <div class="project-body">
              <span class="project-tag">Renovation</span>
              <h3>[Project Name]</h3>
              <div class="project-loc">[Suburb, State]</div>
              <div class="spec-row">
                <span class="spec-chip"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 20v-7a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v7"/><path d="M3 13V9a2 2 0 0 1 2-2h3v4"/><path d="M3 20h18"/></svg>[3] Bed</span>
                <span class="spec-chip"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 12h16M5 12V6a2 2 0 0 1 2-2h2v3M5 20v-4M19 20v-4"/></svg>[2] Bath</span>
                <span class="spec-chip"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="4" y="4" width="16" height="16"/></svg>[165]m²</span>
              </div>
              <p>Short one-line description of the build, materials or standout feature goes here.</p>
            </div>
          </div>
          <div class="project-card reveal">
            <div class="ph-media">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 11.5 12 4l9 7.5"/><path d="M5.5 10v9.5h13V10"/></svg>
              <span class="ph-label">Project photo — add image</span>
            </div>
            <div class="project-body">
              <span class="project-tag">Commercial</span>
              <h3>[Project Name]</h3>
              <div class="project-loc">[Suburb, State]</div>
              <div class="spec-row">
                <span class="spec-chip"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M5 17h14M5 17a2 2 0 0 1-2-2v-2l2-5h10l2 5v2a2 2 0 0 1-2 2M7 17v2M17 17v2"/></svg>[6] Car</span>
                <span class="spec-chip"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="4" y="4" width="16" height="16"/></svg>[480]m²</span>
              </div>
              <p>Short one-line description of the build, materials or standout feature goes here.</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- TESTIMONIALS -->
    <div class="section">
      <div class="container">
        <div class="section-head center reveal" style="margin-left:auto;margin-right:auto;">
          <span class="eyebrow">Client feedback</span>
          <h2>What our clients say</h2>
        </div>
        <div class="testimonial-grid">
          <div class="testimonial-card reveal">
            <p class="testimonial-quote">"[Placeholder quote — swap in a real client comment about their build experience.]"</p>
            <div class="testimonial-person">
              <div class="testimonial-avatar ph-media"></div>
              <div><h4>[Client Name]</h4><span>Homeowner, [Suburb]</span></div>
            </div>
          </div>
          <div class="testimonial-card reveal">
            <p class="testimonial-quote">"[Placeholder quote — swap in a real client comment about their build experience.]"</p>
            <div class="testimonial-person">
              <div class="testimonial-avatar ph-media"></div>
              <div><h4>[Client Name]</h4><span>Homeowner, [Suburb]</span></div>
            </div>
          </div>
          <div class="testimonial-card reveal">
            <p class="testimonial-quote">"[Placeholder quote — swap in a real client comment about their build experience.]"</p>
            <div class="testimonial-person">
              <div class="testimonial-avatar ph-media"></div>
              <div><h4>[Client Name]</h4><span>Homeowner, [Suburb]</span></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- CTA -->
    <div class="section-tight">
      <div class="container">
        <div class="cta-banner reveal">
          <div>
            <h2>Ready to start building?</h2>
            <p>Tell us about your site and vision — we'll come back with next steps and an honest timeline.</p>
          </div>
          <a href="#enquiry" data-link class="btn btn-primary">Get a free enquiry</a>
        </div>
      </div>
    </div>

  </section>

  <section id="about" class="page">

    <div class="page-hero">
      <div class="container">
        <span class="eyebrow">About EDI Homes</span>
        <h1>Built on trades experience, run with an engineer's discipline.</h1>
        <p>We're a small, hands-on construction team that treats every home like it's the only one on our books.</p>
      </div>
    </div>

    <div class="section">
      <div class="container about-hero">
        <div class="reveal">
          <span class="eyebrow">Our story</span>
          <h2>Founded on one idea: build it properly, or don't build it.</h2>
          <p>EDI Homes started with a simple frustration — too many building projects lose quality somewhere between the drawing and the handover. We set out to close that gap, keeping design, trades and project management working from the same plan instead of passing problems down the line.</p>
          <p>[Add your founding story here: who started the company, what year, and what the name EDI stands for or represents to your team.]</p>
        </div>
        <div class="ph-media reveal">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 11.5 12 4l9 7.5"/><path d="M5.5 10v9.5h13V10"/></svg>
          <span class="ph-label">Team or site photo — add image</span>
        </div>
      </div>
    </div>

    <div class="section section-alt">
      <div class="container">
        <div class="section-head center reveal" style="margin-left:auto;margin-right:auto;">
          <span class="eyebrow">What we value</span>
          <h2>The standards we build to</h2>
        </div>
        <div class="values-grid">
          <div class="value-card reveal">
            <div class="service-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3 4 6.5v5c0 5 3.4 8.7 8 9.5 4.6-.8 8-4.5 8-9.5v-5z"/><path d="M9 12l2.2 2.2L15.5 9.5"/></svg></div>
            <h3>Built to last</h3>
            <p>We use materials and methods chosen for durability, not just for passing inspection.</p>
          </div>
          <div class="value-card reveal">
            <div class="service-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="8.5"/><path d="M12 7.5v5l3.2 2"/></svg></div>
            <h3>Honest timelines</h3>
            <p>We tell you what's realistic up front, and flag delays the moment we see them coming.</p>
          </div>
          <div class="value-card reveal">
            <div class="service-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19V6.5A2.5 2.5 0 0 1 6.5 4H18a1 1 0 0 1 1 1v13"/><path d="M4 19a2 2 0 0 0 2 2h13"/><path d="M8 8h7M8 11.5h7"/></svg></div>
            <h3>Clear communication</h3>
            <p>One point of contact for the life of the project — no chasing different trades for updates.</p>
          </div>
        </div>
      </div>
    </div>

    <div class="section">
      <div class="container">
        <div class="section-head reveal">
          <span class="eyebrow">How we work</span>
          <h2>From first call to final key handover.</h2>
        </div>
        <div class="process-rail">
          <div class="process-step reveal">
            <div class="step-num">01</div>
            <h3>Consultation</h3>
            <p>We visit the site, hear your brief and give you an honest read on scope, budget and timeline.</p>
          </div>
          <div class="process-step reveal">
            <div class="step-num">02</div>
            <h3>Design &amp; approval</h3>
            <p>Concept drawings, engineering and council documentation are prepared and lodged.</p>
          </div>
          <div class="process-step reveal">
            <div class="step-num">03</div>
            <h3>Construction</h3>
            <p>Our crew and trusted trades build to plan, with regular updates at every milestone.</p>
          </div>
          <div class="process-step reveal">
            <div class="step-num">04</div>
            <h3>Handover</h3>
            <p>A final walkthrough, defect check and warranty pack before we give you the keys.</p>
          </div>
        </div>
      </div>
    </div>

    <div class="section section-alt">
      <div class="container">
        <div class="section-head center reveal" style="margin-left:auto;margin-right:auto;">
          <span class="eyebrow">The team</span>
          <h2>The people on your project</h2>
        </div>
        <div class="team-grid">
          <div class="team-card reveal">
            <div class="team-avatar ph-media" style="border-radius:50%;"></div>
            <h3>[Full Name]</h3>
            <div class="team-role">[Director / Builder]</div>
          </div>
          <div class="team-card reveal">
            <div class="team-avatar ph-media" style="border-radius:50%;"></div>
            <h3>[Full Name]</h3>
            <div class="team-role">[Site Manager]</div>
          </div>
          <div class="team-card reveal">
            <div class="team-avatar ph-media" style="border-radius:50%;"></div>
            <h3>[Full Name]</h3>
            <div class="team-role">[Design Lead]</div>
          </div>
          <div class="team-card reveal">
            <div class="team-avatar ph-media" style="border-radius:50%;"></div>
            <h3>[Full Name]</h3>
            <div class="team-role">[Client Liaison]</div>
          </div>
        </div>
      </div>
    </div>

    <div class="section-tight">
      <div class="container">
        <div class="cta-banner reveal">
          <div>
            <h2>Want to work with us?</h2>
            <p>Get in touch and we'll walk you through how a project with EDI Homes typically runs.</p>
          </div>
          <a href="#contact" data-link class="btn btn-primary">Contact the team</a>
        </div>
      </div>
    </div>

  </section>

  <section id="projects" class="page">

    <div class="page-hero">
      <div class="container">
        <span class="eyebrow">Our Projects</span>
        <h1>A portfolio of considered, well-built homes.</h1>
        <p>Browse recent work across new builds, renovations and commercial fit-outs. Swap in real project photography and details when ready.</p>
      </div>
    </div>

    <div class="section">
      <div class="container">
        <div class="filter-bar reveal">
          <button class="filter-btn active" data-filter="all">All Projects</button>
          <button class="filter-btn" data-filter="residential">Residential</button>
          <button class="filter-btn" data-filter="renovation">Renovation</button>
          <button class="filter-btn" data-filter="commercial">Commercial</button>
        </div>

        <div class="projects-grid" id="projectsGrid">
          <!-- Project 1 -->
          <div class="project-card reveal" data-category="residential" data-beds="4" data-baths="2" data-car="2">
            <div class="ph-media"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 11.5 12 4l9 7.5"/><path d="M5.5 10v9.5h13V10"/></svg><span class="ph-label">Project photo — add image</span></div>
            <div class="project-body"><span class="project-tag">Residential</span><h3>[Project Name]</h3><div class="project-loc">[Suburb, State]</div><div class="spec-row"><span class="spec-chip"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 20v-7a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v7"/><path d="M3 13V9a2 2 0 0 1 2-2h3v4"/><path d="M3 20h18"/></svg>[4] Bed</span><span class="spec-chip"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 12h16M5 12V6a2 2 0 0 1 2-2h2v3M5 20v-4M19 20v-4"/></svg>[2] Bath</span><span class="spec-chip"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="4" y="4" width="16" height="16"/></svg>[210]m²</span></div><p>Single-storey new build — replace with details on layout, size and completion date.</p></div>
          </div>
          <!-- Project 2 -->
          <div class="project-card reveal" data-category="renovation" data-beds="3" data-baths="2" data-car="1">
            <div class="ph-media"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14.5 3.5 20.5 9.5 9 21H3v-6z"/></svg><span class="ph-label">Project photo — add image</span></div>
            <div class="project-body"><span class="project-tag">Renovation</span><h3>[Project Name]</h3><div class="project-loc">[Suburb, State]</div><div class="spec-row"><span class="spec-chip"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 20v-7a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v7"/><path d="M3 13V9a2 2 0 0 1 2-2h3v4"/><path d="M3 20h18"/></svg>[3] Bed</span><span class="spec-chip"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 12h16M5 12V6a2 2 0 0 1 2-2h2v3M5 20v-4M19 20v-4"/></svg>[2] Bath</span><span class="spec-chip"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="4" y="4" width="16" height="16"/></svg>[165]m²</span></div><p>Kitchen and rear extension — replace with details on scope and standout features.</p></div>
          </div>
          <!-- Project 3 -->
          <div class="project-card reveal" data-category="commercial" data-beds="0" data-baths="0" data-car="4">
            <div class="ph-media"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="5" y="4" width="14" height="17" rx="1.5"/></svg><span class="ph-label">Project photo — add image</span></div>
            <div class="project-body"><span class="project-tag">Commercial</span><h3>[Project Name]</h3><div class="project-loc">[Suburb, State]</div><div class="spec-row"><span class="spec-chip"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="4" y="4" width="16" height="16"/></svg>[320]m²</span></div><p>Retail fit-out — replace with details on client and project brief.</p></div>
          </div>
          <!-- Project 4 -->
          <div class="project-card reveal" data-category="residential" data-beds="5" data-baths="3" data-car="2">
            <div class="ph-media"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 11.5 12 4l9 7.5"/><path d="M5.5 10v9.5h13V10"/></svg><span class="ph-label">Project photo — add image</span></div>
            <div class="project-body"><span class="project-tag">Residential</span><h3>[Project Name]</h3><div class="project-loc">[Suburb, State]</div><div class="spec-row"><span class="spec-chip"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 20v-7a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v7"/><path d="M3 13V9a2 2 0 0 1 2-2h3v4"/><path d="M3 20h18"/></svg>[5] Bed</span><span class="spec-chip"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 12h16M5 12V6a2 2 0 0 1 2-2h2v3M5 20v-4M19 20v-4"/></svg>[3] Bath</span><span class="spec-chip"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="4" y="4" width="16" height="16"/></svg>[310]m²</span></div><p>Two-storey family home — replace with details on layout, size and completion date.</p></div>
          </div>
          <!-- Project 5 -->
          <div class="project-card reveal" data-category="renovation" data-beds="4" data-baths="3" data-car="2">
            <div class="ph-media"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14.5 3.5 20.5 9.5 9 21H3v-6z"/></svg><span class="ph-label">Project photo — add image</span></div>
            <div class="project-body"><span class="project-tag">Renovation</span><h3>[Project Name]</h3><div class="project-loc">[Suburb, State]</div><div class="spec-row"><span class="spec-chip"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 20v-7a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v7"/><path d="M3 13V9a2 2 0 0 1 2-2h3v4"/><path d="M3 20h18"/></svg>[4] Bed</span><span class="spec-chip"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 12h16M5 12V6a2 2 0 0 1 2-2h2v3M5 20v-4M19 20v-4"/></svg>[3] Bath</span><span class="spec-chip"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="4" y="4" width="16" height="16"/></svg>[220]m²</span></div><p>Second-storey addition — replace with details on scope and standout features.</p></div>
          </div>
          <!-- Project 6 -->
          <div class="project-card reveal" data-category="commercial" data-beds="0" data-baths="0" data-car="6">
            <div class="ph-media"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="5" y="4" width="14" height="17" rx="1.5"/></svg><span class="ph-label">Project photo — add image</span></div>
            <div class="project-body"><span class="project-tag">Commercial</span><h3>[Project Name]</h3><div class="project-loc">[Suburb, State]</div><div class="spec-row"><span class="spec-chip"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="4" y="4" width="16" height="16"/></svg>[650]m²</span></div><p>Office refurbishment — replace with details on client and project brief.</p></div>
          </div>
        </div>

        <p id="noResults" style="display:none; text-align:center; color:var(--blue); font-family:var(--font-mono); font-size:0.85rem; margin-top:20px;">No projects in this category yet.</p>
      </div>
    </div>

    <div class="section-tight">
      <div class="container">
        <div class="cta-banner reveal">
          <div>
            <h2>Like what you see?</h2>
            <p>Send us your brief and we'll let you know if it's a fit for the team.</p>
          </div>
          <a href="#enquiry" data-link class="btn btn-primary">Start an enquiry</a>
        </div>
      </div>
    </div>

  </section>

  <section id="contact" class="page">

    <div class="page-hero">
      <div class="container">
        <span class="eyebrow">Contact Us</span>
        <h1>Let's talk about your site.</h1>
        <p>Questions about a project, a quote, or just want to know if we service your area — reach out and we'll get back to you within one business day.</p>
      </div>
    </div>

    <div class="section">
      <div class="container form-layout">

        <div class="reveal">
          <div class="info-card">
            <div class="info-row">
              <div class="icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21s-7-6.1-7-11.5A7 7 0 0 1 19 9.5C19 14.9 12 21 12 21z"/><circle cx="12" cy="9.5" r="2.4"/></svg></div>
              <div><h4>Office</h4><p>[Street Address], [Suburb NSW Postcode]</p></div>
            </div>
            <div class="info-row">
              <div class="icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 5h16v14H4z"/><path d="M4 6l8 7 8-7"/></svg></div>
              <div><h4>Email</h4><p>[info@edihomes.com.au]</p></div>
            </div>
            <div class="info-row">
              <div class="icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3h4l1.5 5-2.5 2a12 12 0 0 0 6 6l2-2.5 5 1.5v4a2 2 0 0 1-2.2 2A18 18 0 0 1 4 5.2 2 2 0 0 1 6 3z"/></svg></div>
              <div><h4>Phone</h4><p>[(02) 0000 0000]</p></div>
            </div>
            <div class="info-row">
              <div class="icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="8.5"/><path d="M12 7.5v5l3.2 2"/></svg></div>
              <div><h4>Hours</h4><p>Mon–Fri, [7:00am – 4:00pm]</p></div>
            </div>
          </div>
          <div class="ph-media map-ph">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 21s-7-6.1-7-11.5A7 7 0 0 1 19 9.5C19 14.9 12 21 12 21z"/><circle cx="12" cy="9.5" r="2.4"/></svg>
            <span class="ph-label">Map embed — add here</span>
          </div>
        </div>

        <div class="reveal">
          <div class="form-card">
            <div id="contactFormWrap">
              <h3 style="margin-bottom:4px;">Send a message</h3>
              <p style="font-size:0.9rem; margin-bottom:22px;">Fill in the form and our team will follow up by email or phone.</p>
              <form id="contactForm" novalidate>
                <div class="form-grid">
                  <div class="field full">
                    <label for="c-name">Full name <span class="req">*</span></label>
                    <input type="text" id="c-name" name="name" required>
                  </div>
                  <div class="field">
                    <label for="c-email">Email <span class="req">*</span></label>
                    <input type="email" id="c-email" name="email" required>
                  </div>
                  <div class="field">
                    <label for="c-phone">Phone</label>
                    <input type="tel" id="c-phone" name="phone">
                  </div>
                  <div class="field full">
                    <label for="c-subject">Subject</label>
                    <input type="text" id="c-subject" name="subject" placeholder="What's this about?">
                  </div>
                  <div class="field full">
                    <label for="c-message">Message <span class="req">*</span></label>
                    <textarea id="c-message" name="message" required></textarea>
                  </div>
                </div>
                <div class="form-foot">
                  <span class="form-note">We'll never share your details with a third party.</span>
                  <button type="submit" class="btn btn-primary">Send message</button>
                </div>
              </form>
            </div>
            <div class="form-success" id="contactSuccess">
              <div class="check"><svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 13l4 4L19 7"/></svg></div>
              <h3>Message sent</h3>
              <p>Thanks for reaching out — this is a design preview, so no message was actually sent yet. Once a backend or form service is connected, submissions will land in your inbox.</p>
              <button class="btn btn-ghost" style="margin-top:20px;" onclick="resetForm('contactForm','contactFormWrap','contactSuccess')">Send another message</button>
            </div>
          </div>
        </div>

      </div>
    </div>

  </section>

  <section id="enquiry" class="page">

    <div class="page-hero">
      <div class="container">
        <span class="eyebrow">Project Enquiry</span>
        <h1>Tell us about your project.</h1>
        <p>The more detail you give us, the more useful our first response will be. This takes about two minutes.</p>
      </div>
    </div>

    <div class="section">
      <div class="container" style="max-width:760px;">
        <div class="form-card reveal">
          <div id="enquiryFormWrap">
            <form id="enquiryForm" novalidate>
              <div class="form-grid">
                <div class="field">
                  <label for="e-name">Full name <span class="req">*</span></label>
                  <input type="text" id="e-name" name="name" required>
                </div>
                <div class="field">
                  <label for="e-email">Email <span class="req">*</span></label>
                  <input type="email" id="e-email" name="email" required>
                </div>
                <div class="field">
                  <label for="e-phone">Phone <span class="req">*</span></label>
                  <input type="tel" id="e-phone" name="phone" required>
                </div>
                <div class="field">
                  <label for="e-suburb">Site suburb</label>
                  <input type="text" id="e-suburb" name="suburb" placeholder="e.g. [Suburb, State]">
                </div>
                <div class="field">
                  <label for="e-type">Project type <span class="req">*</span></label>
                  <select id="e-type" name="type" required>
                    <option value="" disabled selected>Select one</option>
                    <option>New home build</option>
                    <option>Renovation / extension</option>
                    <option>Commercial fit-out</option>
                    <option>Design &amp; documentation only</option>
                    <option>Other</option>
                  </select>
                </div>
                <div class="field">
                  <label for="e-budget">Estimated budget</label>
                  <select id="e-budget" name="budget">
                    <option value="" disabled selected>Select a range</option>
                    <option>Under $100,000</option>
                    <option>$100,000 – $250,000</option>
                    <option>$250,000 – $500,000</option>
                    <option>$500,000+</option>
                    <option>Not sure yet</option>
                  </select>
                </div>
                <div class="field">
                  <label for="e-timing">Preferred start</label>
                  <select id="e-timing" name="timing">
                    <option value="" disabled selected>Select timing</option>
                    <option>As soon as possible</option>
                    <option>Within 3 months</option>
                    <option>Within 6–12 months</option>
                    <option>Just researching</option>
                  </select>
                </div>
                <div class="field">
                  <label for="e-contact">Preferred contact method</label>
                  <select id="e-contact" name="contactMethod">
                    <option value="" disabled selected>Select one</option>
                    <option>Phone call</option>
                    <option>Email</option>
                    <option>Text message</option>
                  </select>
                </div>
                <div class="field full">
                  <label for="e-message">Project details <span class="req">*</span></label>
                  <textarea id="e-message" name="message" placeholder="Tell us about the site, what you're hoping to build, and any plans you already have." required></textarea>
                </div>
              </div>
              <div class="form-foot">
                <span class="form-note">Fields marked <span class="req">*</span> are required.</span>
                <button type="submit" class="btn btn-primary btn-block" style="width:auto;">Submit enquiry</button>
              </div>
            </form>
          </div>
          <div class="form-success" id="enquirySuccess">
            <div class="check"><svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 13l4 4L19 7"/></svg></div>
            <h3>Enquiry received</h3>
            <p>Thanks — this is a design preview, so nothing was actually submitted yet. Once connected to a backend or form service, enquiries like this will be emailed straight to your team.</p>
            <button class="btn btn-ghost" style="margin-top:20px;" onclick="resetForm('enquiryForm','enquiryFormWrap','enquirySuccess')">Submit another enquiry</button>
          </div>
        </div>
      </div>
    </div>

  </section>
@endsection