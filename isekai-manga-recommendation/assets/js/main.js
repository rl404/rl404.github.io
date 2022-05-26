(function () {
  initArea();
})();

function initArea() {
  qArea = `<h1><abbr title="Isekai is a Japanese genre of portal fantasy and science fiction. It includes novels, light novels, films, manga, anime and video games that revolve around a person or people who are transported to and have to survive in another world, such as a fantasy world, virtual world, another planet, or parallel universe.">Isekai</abbr><br>Manga<br>Recommendation</h1>`;
  $('#question-area').html(qArea);

  oArea = `<div class='row option-row'>`;
  oArea += `<button class='btn btn-outline-light option-button' onclick='setArea(1)'>Let's Go</button>`;
  oArea += `</div>`;
  $('#option-area').html(oArea);
}

function setArea(qID) {
  if (qID === 0) {
    initArea();
    return;
  }

  const q = Questions[qID];

  qArea = `<h1>${q.question}</h1>`;
  $('#question-area').html(qArea);

  oArea = '';
  q.options.forEach((o) => {
    oArea += `<div class='row option-row'>`;
    if (o.manga) {
      oArea += `<button class='btn btn-outline-light btn-block option-button' onclick='setManga(${o.manga})' data-toggle="modal" data-target="#manga-modal">${Mangas[o.manga].title}</button>`;
    } else {
      oArea += `<button class='btn btn-outline-light btn-block option-button' onclick='setArea(${o.next})'>${o.answer}</button>`;
    }
    oArea += `</div>`;
  });

  oArea += `<div class='row option-row'>`;
  oArea += `<div class='col-6'><button class='btn btn-dark btn-block' onclick='setArea(${q.prev})'>Back</button></div>`;
  oArea += `<div class='col-6'><button class='btn btn-dark btn-block' onclick='setArea(0)'>Reset</button></div>`;
  oArea += `</div>`;

  $('#option-area').html(oArea);
}

function setManga(mID) {
  const m = Mangas[mID];

  mImage = `<img src='assets/images/${mID}.jpg' alt='${m.title}' class='img-thumbnail'>`;
  $('#manga-image').html(mImage);

  mTitle = `<h2><img src='assets/images/japan-flag.svg' class='img-flag'> ${m.title}</h2>`;
  $('#manga-title').html(mTitle);

  if (m.title2 !== '') {
    mTitle2 = `<h5 class="text-muted"><img src='assets/images/english-flag.svg' class='img-flag'> ${m.title2}</h5>`;
    $('#manga-title2').html(mTitle2);
  } else {
    $('#manga-title2').html('');
  }

  var badge = '';
  badge += `<span class="badge badge-primary">${m.race}</span> `;
  badge += `<span class="badge badge-primary">${m.role}</span> `;
  badge += `<span class="badge badge-primary">${m.skill}</span> `;
  badge += m.antiHero ? `<span class="badge badge-warning">anti-hero</span>` : '';
  $('#manga-badge').html(badge);

  mDesc = `<p>${m.description}</p>`;
  $('#manga-description').html(mDesc);

  mLink = `<a class='btn btn-primary' href='https://myanimelist.net/manga/${mID}' target='_blank'>Link</a>`;
  $('#manga-link').html(mLink);
}
