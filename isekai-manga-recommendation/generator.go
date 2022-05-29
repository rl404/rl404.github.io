package main

import (
	"encoding/csv"
	"encoding/json"
	"io/ioutil"
	"os"
	"strings"
)

type manga struct {
	Title       string `json:"title"`
	Title2      string `json:"title2"`
	Description string `json:"description"`
	Race        string `json:"race"`
	Role        string `json:"role"`
	Skill       string `json:"skill"`
	AntiHero    bool   `json:"antiHero"`
	Recommended bool   `json:"recommended"`
	NSFW        bool   `json:"nsfw"`
}

func main() {
	f, err := os.Open("isekai.csv")
	if err != nil {
		panic(err)
	}
	defer f.Close()

	a := csv.NewReader(f)
	data, err := a.ReadAll()
	if err != nil {
		panic(err)
	}

	m := make(map[string]manga)

	for i, d := range data {
		if i == 0 {
			continue
		}

		m[d[0]] = manga{
			Title:       d[1],
			Title2:      d[2],
			Description: toDesc(d[3]),
			Race:        d[4],
			Role:        d[5],
			Skill:       d[6],
			AntiHero:    toBool(d[7]),
			Recommended: toBool(d[8]),
			NSFW:        toBool(d[9]),
		}
	}

	jData, err := json.MarshalIndent(m, "", " ")
	if err != nil {
		panic(err)
	}

	js := `var Mangas = ` + string(jData)

	ioutil.WriteFile("assets/manga.js", []byte(js), 0644)
}

func toBool(b string) bool {
	switch b {
	case "0":
		return false
	case "1":
		return true
	default:
		return false
	}
}

func toDesc(d string) string {
	d = strings.ReplaceAll(d, "\n\n", "<br>")
	return strings.ReplaceAll(d, "\n", "")
}
