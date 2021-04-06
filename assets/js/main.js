(function () {
  $('#name').html(Data.name);
  $('#summary').html(Data.summary);

  var detailArea = "<div class='row'>";
  detailArea += `<div class='col-lg-3 col-md-4 col-sm-6 subtitle'><i class="fas fa-map-marker-alt"></i> ${Data.address}</div>`;
  // detailArea += `<div class='col-lg-3 col-md-4 col-sm-6 subtitle'><i class="fas fa-phone"></i> ${Data.phone}</div>`;
  detailArea += `<div class='col-lg-3 col-md-4 col-sm-6 subtitle'><i class="fas fa-envelope"></i> ${Data.email}</div>`;
  detailArea += `<div class='col-lg-3 col-md-4 col-sm-6 subtitle'><a href='${Data.github.link}' target='_blank'><i class="fab fa-github"></i> ${Data.github.name}</a></div>`;
  detailArea += `<div class='col-lg-3 col-md-4 col-sm-6 subtitle'><a href='${Data.linkedin.link}' target='_blank'><i class="fab fa-linkedin-in"></i> ${Data.linkedin.name}</a></div>`;
  detailArea += `<div class='col-lg-3 col-md-4 col-sm-6 subtitle'><a href='${Data.resume}' target='_blank'><i class="fas fa-file-pdf"></i> Resume</a></div>`;
  detailArea += "</div>";
  $('#details').html(detailArea);

  $('#experience-count').html(`(${Data.experience.length})`);

  var expArea = "<div class='row'>";
  Data.experience.forEach(e => {
    var title = "<div class='col-lg-3 col-md-5 col-sm-12'>";
    title += "<div class='row'>";
    title += `<div class='col-sm-12'><h5 class='title'><a href='${e.link}' target='_blank'>${e.company}</a></h5></div>`;
    title += `<div class='col-md-12 col-sm-6 subtitle'><i class="fas fa-user-friends"></i> ${e.team}</div>`;
    title += `<div class='col-md-12 col-sm-6 subtitle'><i class="fas fa-map-marker-alt"></i> ${e.location}</div>`;
    title += `<div class='col-md-12 col-sm-6 subtitle'><i class="fas fa-calendar-alt"></i> ${e.startDate} - ${e.endDate}</div>`;
    title += "</div></div>";

    var data = "<div class='col-lg-9 col-md-7 col-sm-12'>";
    data += `<h5 class='title'>${e.position}</h5>`;
    data += "<ul>";
    e.work.forEach(w => {
      data += `<li>${w}</li>`;
    })
    data += "</ul></div>";

    expArea += title + data;
  })
  expArea += "</div>";
  $('#experience').html(expArea);

  $('#education-count').html(`(${Data.education.length})`);

  var eduArea = "<div class='row'>";
  Data.education.forEach(e => {
    var title = "<div class='col-lg-3 col-md-5 col-sm-12'>";
    title += "<div class='row'>";
    title += `<div class='col-sm-12'><h5 class='title'><a href='${e.link}' target='_blank'>${e.school}</a></h5></div>`;
    title += `<div class='col-md-12 col-sm-6 subtitle'><i class="fas fa-map-marker-alt"></i> ${e.location}</div>`;
    title += `<div class='col-md-12 col-sm-6 subtitle'><i class="fas fa-calendar-alt"></i> ${e.startDate} - ${e.endDate}</div>`;
    title += "</div></div>";

    var data = "<div class='col-lg-9 col-md-7 col-sm-12'>";
    data += `<h5 class='title'>${e.position}</h5>`;
    data += "<ul>";
    e.list.forEach(w => {
      data += `<li>${w}</li>`;
    })
    data += "</ul></div>";

    eduArea += title + data;
  })
  eduArea += "</div>";
  $('#education').html(eduArea);

  $('#activity-count').html(`(${Data.activity.length})`);

  var actArea = "<div class='row'>";
  Data.activity.forEach(e => {
    var title = "<div class='col-lg-3 col-md-5 col-sm-12'>";
    title += "<div class='row'>";
    title += `<div class='col-sm-12'><h5 class='title'><a href='${e.link}' target='_blank'>${e.place}</a></h5></div>`;
    title += `<div class='col-md-12 col-sm-6 subtitle'><i class="fas fa-map-marker-alt"></i> ${e.location}</div>`;
    title += `<div class='col-md-12 col-sm-6 subtitle'><i class="fas fa-calendar-alt"></i> ${e.startDate} - ${e.endDate}</div>`;
    title += "</div></div>";

    var data = "<div class='col-lg-9 col-md-7 col-sm-12'>";
    data += `<h5 class='title'>${e.position}</h5>`;
    data += "<ul>";
    e.description.forEach(w => {
      data += `<li>${w}</li>`;
    })
    data += "</ul></div>";

    actArea += title + data;
  })
  actArea += "</div>";
  $('#activity').html(actArea);

  $('#language-count').html(`(${Data.language.length})`);

  var langArea = "<div class='row'>";
  Data.language.forEach(l => {
    var title = "<div class='col-6'>";
    title += l.name;
    title += "</div>";

    var data = "<div class='col-6 subtitle'>";
    for (let index = 0; index < l.level; index++) {
      data += "<i class='fas fa-star'></i>";
    }
    for (let index = 0; index < 5 - l.level; index++) {
      data += "<i class='far fa-star'></i>";
    }
    data += "</div>";

    langArea += title + data;
  })
  langArea += "</div>";
  $('#language').html(langArea);

  $('#skill-count').html(`(${Data.skill.length})`);

  var skillArea = "<div class='row'>";
  Data.skill.forEach(l => {
    var title = "<div class='col-lg-3 col-md-4 col-6'>";
    title += l.name;
    title += "</div>";

    // var data = "<div class='col-6 subtitle'>";
    // for (let index = 0; index < l.level; index++) {
    //   data += "<i class='fas fa-star'></i>";
    // }
    // for (let index = 0; index < 5 - l.level; index++) {
    //   data += "<i class='far fa-star'></i>";
    // }
    // data += "</div>";

    skillArea += title;
  })
  skillArea += "</div>";
  $('#skill').html(skillArea);

  $('#project-count').html(`(${Data.project.personal.length + Data.project.work.length})`);

  var projArea = "<div class='row'>";
  Data.project.personal.forEach(p => {
    projArea += "<div class='col-sm-6'>";
    projArea += `<h5 class='title'>${p.link !== '' ? `<a href='${p.link}' target='_blank'>${p.name}</a>` : p.name}</h5>`;
    projArea += `<p>${p.description}</p>`;
    projArea += `<p class='subtitle'><i class='fas fa-tag'></i> ${p.tag.join(', ')}</p>`;
    projArea += "</div>";
  })
  Data.project.work.forEach(p => {
    projArea += "<div class='col-sm-6'>";
    projArea += `<h5 class='title'>${p.link !== '' ? `<a href='${p.link}' target='_blank'>${p.name}</a>` : p.name}</h5>`;
    projArea += `<p>${p.description}</p>`;
    projArea += `<p class='subtitle'><i class='fas fa-tag'></i> ${p.tag.join(', ')}</p>`;
    projArea += "</div>";
  })
  projArea += "</div>";
  $('#project').html(projArea);
})();
