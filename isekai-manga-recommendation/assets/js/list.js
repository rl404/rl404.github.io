(function () {
  fillTable();

  var table = $('#manga-table').DataTable({
    fixedHeader: true,
    order: [[1, 'asc']],
    lengthMenu: [
      [20, 50, 100, -1],
      [20, 50, 100, 'All'],
    ],
    columnDefs: [
      {
        target: 0,
        searchable: false,
      },
      {
        target: 7,
        searchable: false,
      },
    ],
  });
})();

function fillTable() {
  table = `<table id='manga-table' class="table table-striped table-bordered table-hover">`;
  table += `<thead>`;
  table += `<tr>`;
  table += `<th>ID</th>`;
  table += `<th>Title JP</th>`;
  table += `<th>Title EN</th>`;
  table += `<th>Race</th>`;
  table += `<th>Role/Job</th>`;
  table += `<th>Weapon/Skill</th>`;
  table += `<th>Anti-hero</th>`;
  table += `<th>Action</th>`;
  table += `</tr>`;
  table += `</thead>`;
  table += `<tbody>`;
  Object.entries(Mangas).forEach(([id, m]) => {
    table += `<tr>`;
    table += `<td>${id}</td>`;
    table += `<td>${m.title}</td>`;
    table += `<td>${m.title2}</td>`;
    table += `<td>${m.race}</td>`;
    table += `<td>${m.role}</td>`;
    table += `<td>${m.skill}</td>`;
    table += `<td>${m.antiHero}</td>`;
    table += `<td><button class='btn btn-outline-light btn-block option-button' onclick='setManga(${id})' data-toggle="modal" data-target="#manga-modal">Detail</button></td>`;
    table += `</tr>`;
  });
  table += `</tbody>`;
  table += `</table>`;
  $('#list-area').html(table);
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
