import "./bootstrap";
import "fastbootstrap";

import Alpine from "alpinejs";
import Choices from "choices.js";
import focus from "@alpinejs/focus";
import axios from "axios";
import Chart from "chart.js/auto";
import { Colors } from "chart.js";
Alpine.plugin(focus);

window.Alpine = Alpine;

if (document.querySelector(".select-choice")) {
    new Choices(".select-choice");
}

document.addEventListener("alpine:init", () => {
    Alpine.data("imgPreview", () => ({
        imgsrc: null,
        previewFile() {
            let file = this.$refs.myFile.files[0];
            if (!file || file.type.indexOf("image/") === -1) return;
            this.imgsrc = null;
            let reader = new FileReader();

            reader.onload = (e) => {
                this.imgsrc = e.target.result;
            };

            reader.readAsDataURL(file);
        },
    }));
});

window.dragDropList = function(items, dragging, dropping) {
    if (dragging !== null && dropping !== null) {
        if (dragging < dropping) {
            items = [
                ...items.slice(0, dragging),
                ...items.slice(dragging + 1, dropping + 1),
                items[dragging],
                ...items.slice(dropping + 1),
            ];
        } else {
            items = [
                ...items.slice(0, dropping),
                items[dragging],
                ...items.slice(dropping, dragging),
                ...items.slice(dragging + 1),
            ];
        }
        dropping = null;
    }

    updateChapterOrders(items);

    return items;
};

function updateChapterOrders(items) {
    const updatedItems = items.map((item, idx) => {
        let next_chapter_id = null;
        if (idx !== items.length - 1) {
            next_chapter_id = items[idx + 1].id;
        }
        return {
            id: item.id,
            next_chapter_id: next_chapter_id,
        };
    });

    const apiUrl = "/teacher/chapter/updateorders";

    axios
        .put(apiUrl, {
            chapter_order: updatedItems,
        })
        .then((response) => { })
        .catch((error) => {
            console.log("error", error);
        })
        .finally(() => {
            console.log("Orders updated successfully");
        });
}

window.chart = (async function() {
    try {
        const { data } = await axios.get("/api/teacher/grouprevenue");
        const canvas = document.getElementById("totalRevenue");

        if (Array.isArray(data.data)) {
            const revenueData = data.data;
            new Chart(canvas, {
                type: "bar",
                data: {
                    labels: revenueData.map((row) => row.title),
                    datasets: [
                        {
                            label: "Total revenue",
                            data: revenueData.map((row) => row.revenue),
                        },
                    ],
                },
            });
        } else {
            console.error("Something wen wrong!", error);
        }
    } catch (error) {
        console.error("Error getting data from API", error);
    }
})();

Alpine.start();
