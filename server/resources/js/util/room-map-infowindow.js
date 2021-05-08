import { store } from "../store";

const infoWindow = {
  getContentHtml(marker) {
    const src =
      marker.room.profileImage.image == ""
        ? `${store.state.baseUrl}/uploads/defaults/avatar.png`
        : `${store.state.baseUrl}/uploads/portfolios/${marker.room.id}/${marker.room.profileImage.image}`;
    return `
      <div class="info-window border border-grey rounded">
        <a href="/#/profiles/?id=${marker.room.id}">
          <div class="tooltip-body">
            <img class="imageClass" src="${src}"/>
            <div class="tooltip-name khvc-h4">${
              marker.room.first_name + " " + marker.room.last_name
            }</div>
          </div>
        </a>
      </div>`;
  },
};

export default infoWindow;
