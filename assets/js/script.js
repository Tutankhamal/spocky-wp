document.addEventListener("DOMContentLoaded", () => {
  // Variables
  const navbar = document.querySelector(".navbar")
  const hamburger = document.querySelector(".hamburger")
  const navLinks = document.querySelector(".nav-links")
  const faqItems = document.querySelectorAll(".faq-item")
  const partnerCards = document.querySelectorAll(".partner-card")
  const modalOverlay = document.querySelector(".modal-overlay")
  const closeModal = document.querySelector(".close-modal")
  const filterButtons = document.querySelectorAll(".filter-button")
  let lastScrollTop = 0

  const backToTopButton = document.getElementById("backToTop")

  if (backToTopButton) {
    window.addEventListener("scroll", () => {
      if (window.scrollY > 100) {
        backToTopButton.classList.add("show")
      } else {
        backToTopButton.classList.remove("show")
      }
    })

    backToTopButton.addEventListener("click", () => {
      window.scrollTo({ top: 0, behavior: "smooth" })
    })
  }

  // Event Listeners
  window.addEventListener("scroll", handleScroll)
  if (hamburger) {
    hamburger.addEventListener("click", toggleMenu)
  }

  // Initialize FAQ accordions
  faqItems.forEach((item) => {
    const question = item.querySelector(".faq-question")
    if (question) {
      question.addEventListener("click", () => {
        item.classList.toggle("active")
      })
    }
  })

  // Functions
  function handleScroll() {
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop

    // Navbar hide/show on scroll
    if (navbar) {
      if (scrollTop > lastScrollTop && scrollTop > 100) {
        navbar.classList.add("hidden")
      } else {
        navbar.classList.remove("hidden")
      }
    }

    lastScrollTop = scrollTop
    animateOnScroll()
  }

  function toggleMenu() {
    if (!hamburger || !navLinks) return
    hamburger.classList.toggle("active")
    navLinks.classList.toggle("active")
    document.body.classList.toggle("no-scroll")
  }

  // Hero Logo Animation
  const heroLogo = document.querySelector(".hero-logo")
  if (heroLogo) {
    heroLogo.addEventListener("mouseover", () => {
      heroLogo.style.filter = "drop-shadow(0 0 15px var(--primary-color))"
    })

    heroLogo.addEventListener("mouseout", () => {
      heroLogo.style.filter = ""
    })
  }

  const heroMainContent = document.getElementById("heroMainContent")
  const heroAdContent = document.getElementById("heroAdContent")
  const heroSlider = document.getElementById("heroSlider")

  // Efeito de entrada
  if (heroMainContent) {
    setTimeout(() => {
      heroMainContent.classList.add("mosaic-in")
    }, 100)
  }

  let showingMain = true
  function toggleHeroContent() {
    if (heroMainContent && heroAdContent && heroSlider) {
      heroSlider.classList.add("slide-left")
      setTimeout(() => {
        if (showingMain) {
          heroMainContent.style.display = "none"
          heroAdContent.style.display = "flex"
          heroAdContent.classList.add("mosaic-in")
          heroMainContent.classList.remove("mosaic-in")
        } else {
          heroAdContent.style.display = "none"
          heroMainContent.style.display = "flex"
          heroMainContent.classList.add("mosaic-in")
          heroAdContent.classList.remove("mosaic-in")
        }
        heroSlider.classList.remove("slide-left")
        showingMain = !showingMain
      }, 900)
    }
  }

  if (heroMainContent && heroAdContent && heroSlider) {
    setInterval(toggleHeroContent, 10000)
  }

  // Video Card Hover Effects
  const videoCards = document.querySelectorAll(".video-card")
  videoCards.forEach((card) => {
    card.addEventListener("mouseover", () => {
      const playButton = card.querySelector(".play-button")
      if (playButton) {
        playButton.style.opacity = "1"
      }
    })

    card.addEventListener("mouseout", () => {
      const playButton = card.querySelector(".play-button")
      if (playButton) {
        playButton.style.opacity = "0"
      }
    })
  })
})

// Partners Carousel
document.addEventListener("DOMContentLoaded", () => {
  const track = document.querySelector(".carousel-track")
  const container = document.querySelector(".carousel-container")

  if (!track || !container) return

  const slides = Array.from(track.children)
  const pauseTime = 2000
  const slideTime = 3000
  let paused = false
  let timeout

  function animateBrightness(img, from, to, duration = 1500) {
    const startTime = performance.now()

    function step(currentTime) {
      const elapsed = currentTime - startTime
      const progress = Math.min(elapsed / duration, 1)
      const brightness = from + (to - from) * progress
      img.style.filter = `brightness(${brightness.toFixed(2)})`

      if (progress < 1) {
        requestAnimationFrame(step)
      }
    }

    requestAnimationFrame(step)
  }

  function activateZoom() {
    slides.forEach((s) => {
      const img = s.querySelector("img")
      if (img) {
        s.classList.remove("active")
        img.style.transform = "scale(1)"
        img.style.filter = "brightness(1)"
      }
    })

    if (slides.length > 0) {
      const activeSlide = slides[0]
      const activeImg = activeSlide.querySelector("img")
      if (activeImg) {
        activeSlide.classList.add("active")
        activeImg.style.transform = "scale(1.45)"
        animateBrightness(activeImg, 1, 1.5, 1500)
      }
    }
  }

  function next() {
    if (paused || slides.length === 0) return
    track.style.transition = `transform ${slideTime}ms cubic-bezier(0.77, 0, 0.175, 1)`
    track.style.transform = `translateX(-100%)`
    track.addEventListener("transitionend", onTransitionEnd, { once: true })
  }

  function onTransitionEnd() {
    track.style.transition = "none"
    track.style.transform = "translateX(0)"
    const first = slides.shift()
    track.appendChild(first)
    slides.push(first)
    activateZoom()
    timeout = setTimeout(next, pauseTime)
  }

  slides.forEach((slide) => {
    const img = slide.querySelector("img")
    if (img) {
      img.addEventListener("click", (e) => {
        const link = e.currentTarget.dataset.link
        if (link) window.open(link, "_blank")
      })
    }
  })

  container.addEventListener("mouseenter", () => {
    paused = true
    clearTimeout(timeout)
    track.style.transition = ""
  })

  container.addEventListener("mouseleave", () => {
    paused = false
    setTimeout(next, 300)
  })

  if (slides.length > 0) {
    activateZoom()
    timeout = setTimeout(next, pauseTime)
  }
})

// Shine carousel
document.addEventListener("DOMContentLoaded", () => {
  const shineTrack = document.querySelector(".shine-carousel-track")
  const shineContainer = document.querySelector(".shine-carousel-container")

  if (!shineTrack || !shineContainer) return

  const shineSlides = Array.from(shineTrack.children)
  const pauseTime = 2800
  const slideTime = 2000
  let shinePaused = false
  let shineTimeout

  function activateShine() {
    shineSlides.forEach((s) => s.classList.remove("active"))
    if (shineSlides.length > 0) {
      shineSlides[0].classList.add("active")
    }
  }

  function nextShine() {
    if (shinePaused || shineSlides.length === 0) return
    shineTrack.style.transition = `transform ${slideTime}ms ease-in-out`
    shineTrack.style.transform = `translateX(-100%)`
    shineTrack.addEventListener("transitionend", onShineTransitionEnd, { once: true })
  }

  function onShineTransitionEnd() {
    shineTrack.style.transition = "none"
    shineTrack.style.transform = "translateX(0)"
    const first = shineSlides.shift()
    shineTrack.appendChild(first)
    shineSlides.push(first)
    activateShine()
    shineTimeout = setTimeout(nextShine, pauseTime)
  }

  shineSlides.forEach((slide) => {
    const img = slide.querySelector("img")
    if (img) {
      img.addEventListener("click", (e) => {
        const link = e.currentTarget.dataset.link
        if (link) window.open(link, "_blank")
      })
    }
  })

  shineContainer.addEventListener("mouseenter", () => {
    shinePaused = true
    clearTimeout(shineTimeout)
    shineTrack.style.transition = ""
  })

  shineContainer.addEventListener("mouseleave", () => {
    shinePaused = false
    setTimeout(nextShine, 300)
  })

  if (shineSlides.length > 0) {
    activateShine()
    shineTimeout = setTimeout(nextShine, pauseTime)
  }
})

// Background Pacman
function initializePacmanBackground() {
  const canvas = document.getElementById("retro-bg")
  if (!canvas) {
    const newCanvas = document.createElement("canvas")
    newCanvas.id = "retro-bg"
    newCanvas.style.cssText = `
      position: fixed;
      top: 0;
      left: 0;
      z-index: -1;
      width: 100vw;
      height: 100vh;
      background: #0a001f;
      display: block;
      pointer-events: auto;
    `
    document.body.appendChild(newCanvas)
    return newCanvas
  }
  return canvas
}

// Initialize Pacman only on home page
if (document.body.classList.contains("home") || window.location.pathname === "/") {
  const canvas = initializePacmanBackground()
  if (canvas) {
    const ctx = canvas.getContext("2d")

    let width = (canvas.width = window.innerWidth)
    let height = (canvas.height = window.innerHeight)

    const baseTileSize = 40
    let tileSize = baseTileSize
    let cols, rows, halfCols
    let maze = []

    const mazeColors = ["hsla(348, 97%, 56%, 0.15)", "hsla(282, 60%, 55%, 0.15)"]
    const baseMazeColor = mazeColors[Math.floor(Math.random() * mazeColors.length)]
    let mazeColor = baseMazeColor
    let rgbMode = false
    let rgbHue = 0
    let fruit = null

    function calculateTileSize() {
      const width = window.innerWidth
      if (width >= 1920) {
        return baseTileSize * 1.2
      } else if (width >= 1280 && width < 1920) {
        const ratio = (width - 1280) / (1920 - 1280)
        const proportionalSize = baseTileSize + baseTileSize * 0.2 * ratio
        return proportionalSize * 1.2
      } else {
        return baseTileSize
      }
    }

    function generateClassicMaze() {
      const leftMaze = Array.from({ length: rows }, () => Array(halfCols).fill(1))
      const visited = Array.from({ length: rows }, () => Array(halfCols).fill(false))

      function isValid(x, y) {
        return x > 0 && x < halfCols - 1 && y > 0 && y < rows - 1
      }

      function shuffleArray(array) {
        for (let i = array.length - 1; i > 0; i--) {
          const j = Math.floor(Math.random() * (i + 1))
          const temp = array[i]
          array[i] = array[j]
          array[j] = temp
        }
        return array
      }

      function carveMaze(x, y) {
        visited[y][x] = true
        leftMaze[y][x] = 0
        const directions = shuffleArray([
          [0, -2],
          [0, 2],
          [-2, 0],
          [2, 0],
        ])
        for (const direction of directions) {
          const dx = direction[0]
          const dy = direction[1]
          const nx = x + dx
          const ny = y + dy
          if (isValid(nx, ny) && !visited[ny][nx]) {
            leftMaze[y + dy / 2][x + dx / 2] = 0
            carveMaze(nx, ny)
          }
        }
      }

      carveMaze(1, 1)

      maze = Array.from({ length: rows }, (_, y) => {
        const mirroredRow = [...leftMaze[y]]
        const rightHalf = [...mirroredRow].reverse()
        const row = cols % 2 === 0 ? mirroredRow.concat(rightHalf) : mirroredRow.concat([0], rightHalf)
        const middleCol = Math.floor(cols / 2)
        const middleRow = Math.floor(rows / 2)
        const corridorSize = 4

        for (let yy = middleRow - Math.floor(corridorSize / 2); yy < middleRow + Math.ceil(corridorSize / 2); yy++) {
          if (yy === y) {
            for (
              let xx = middleCol - Math.floor(corridorSize / 2);
              xx < middleCol + Math.ceil(corridorSize / 2);
              xx++
            ) {
              if (row[xx] !== undefined) row[xx] = 0
            }
          }
        }

        return row
      })

      addExtraOpenings(0.08)
      maze[1][1] = maze[1][2] = maze[2][1] = 0
    }

    function addExtraOpenings(chance = 0.1) {
      for (let y = 1; y < rows - 1; y++) {
        for (let x = 1; x < cols - 1; x++) {
          if (maze[y][x] === 1 && Math.random() < chance) {
            if (x % 2 === 1 || y % 2 === 1) {
              maze[y][x] = 0
            }
          }
        }
      }
    }

    const mouse = { x: 0, y: 0 }

    document.addEventListener("mousemove", (e) => {
      mouse.x = Math.min(cols - 1, Math.max(0, Math.floor(e.clientX / tileSize)))
      mouse.y = Math.min(rows - 1, Math.max(0, Math.floor(e.clientY / tileSize)))
    })

    document.addEventListener("touchstart", (e) => {
      const touch = e.touches[0]
      mouse.x = Math.floor(touch.clientX / tileSize)
      mouse.y = Math.floor(touch.clientY / tileSize)
    })

    class Particle {
      constructor() {
        this.reset()
      }

      reset() {
        this.x = Math.random() * width
        this.y = Math.random() * height
        this.size = Math.floor(Math.random() * 3 + 2)
        this.baseX = this.x
        this.baseY = this.y
        this.hue = Math.floor(Math.random() * 360)
        this.hueSpeed = Math.random() * 0.5 + 0.1
      }

      draw() {
        const color = `hsla(${this.hue}, 100%, 60%, 0.25)`
        ctx.fillStyle = color
        ctx.shadowColor = color
        ctx.shadowBlur = 4
        ctx.fillRect(this.x, this.y, this.size, this.size)
      }

      update() {
        this.hue = (this.hue + this.hueSpeed) % 360
        const dx = this.x - mouse.x * tileSize
        const dy = this.y - mouse.y * tileSize
        const dist = Math.sqrt(dx * dx + dy * dy)
        const maxDist = 120
        const force = (maxDist - dist) / maxDist
        if (dist < maxDist) {
          this.x += (dx / dist) * force * 1.2
          this.y += (dy / dist) * force * 1.2
        } else {
          this.x += (this.baseX - this.x) * 0.02
          this.y += (this.baseY - this.y) * 0.02
        }
      }
    }

    let particles = []

    const pacman = {
      x: 1,
      y: 1,
      px: 1,
      py: 1,
      angle: 0,
      direction: "right",
      path: [],
      speed: 0.07,
      moving: false,
      target: null,
      lastGoal: { x: 1, y: 1 },
    }

    let lastPathCheck = 0

    function findPath(start, end) {
      const openSet = [start]
      const cameFrom = {}
      const gScore = {}
      const fScore = {}
      const nodeKey = (n) => `${n.x},${n.y}`
      gScore[nodeKey(start)] = 0
      fScore[nodeKey(start)] = Math.abs(start.x - end.x) + Math.abs(start.y - end.y)

      while (openSet.length > 0) {
        openSet.sort((a, b) => fScore[nodeKey(a)] - fScore[nodeKey(b)])
        const current = openSet.shift()
        if (current.x === end.x && current.y === end.y) {
          const path = []
          let temp = current
          while (temp && nodeKey(temp) !== nodeKey(start)) {
            path.unshift(temp)
            temp = cameFrom[nodeKey(temp)]
          }
          return path
        }

        const neighbors = [
          { x: current.x + 1, y: current.y },
          { x: current.x - 1, y: current.y },
          { x: current.x, y: current.y + 1 },
          { x: current.x, y: current.y - 1 },
        ]

        for (const neighbor of neighbors) {
          if (
            neighbor.x < 0 ||
            neighbor.x >= cols ||
            neighbor.y < 0 ||
            neighbor.y >= rows ||
            maze[neighbor.y][neighbor.x] === 1
          )
            continue

          const tentativeG = gScore[nodeKey(current)] + 1
          const key = nodeKey(neighbor)
          if (!(key in gScore) || tentativeG < gScore[key]) {
            cameFrom[key] = current
            gScore[key] = tentativeG
            fScore[key] = tentativeG + Math.abs(neighbor.x - end.x) + Math.abs(neighbor.y - end.y)
            if (!openSet.find((n) => n.x === neighbor.x && n.y === neighbor.y)) {
              openSet.push(neighbor)
            }
          }
        }
      }
      return []
    }

    function updatePacman() {
      const now = performance.now()
      const target = { x: mouse.x, y: mouse.y }

      if (!pacman.moving && (target.x !== pacman.lastGoal.x || target.y !== pacman.lastGoal.y)) {
        if (now - lastPathCheck > 100) {
          pacman.path = findPath({ x: Math.round(pacman.px), y: Math.round(pacman.py) }, target)
          pacman.lastGoal = { ...target }
          lastPathCheck = now
        }
      }

      if (!pacman.moving && pacman.path.length > 0) {
        pacman.target = pacman.path.shift()
        pacman.moving = true
        const dx = pacman.target.x - pacman.px
        const dy = pacman.target.y - pacman.py
        if (dx > 0) pacman.direction = "right"
        else if (dx < 0) pacman.direction = "left"
        else if (dy > 0) pacman.direction = "down"
        else if (dy < 0) pacman.direction = "up"
      }

      if (pacman.moving && pacman.target) {
        const dx = pacman.target.x - pacman.px
        const dy = pacman.target.y - pacman.py
        const dist = Math.sqrt(dx * dx + dy * dy)
        if (dist < pacman.speed) {
          pacman.px = pacman.target.x
          pacman.py = pacman.target.y
          pacman.x = pacman.target.x
          pacman.y = pacman.target.y
          pacman.moving = false
          pacman.target = null
          if (fruit && pacman.x === fruit.x && pacman.y === fruit.y) {
            fruit = null
            pacman.fruitCount = (pacman.fruitCount || 0) + 1
            if (pacman.fruitCount >= 3) rgbMode = true
            setTimeout(placeFruit, 3000)
          }
        } else {
          pacman.px += (dx / dist) * pacman.speed
          pacman.py += (dy / dist) * pacman.speed
        }
      }

      pacman.angle += 0.2
    }

    function drawPacman() {
      const cx = pacman.px * tileSize + tileSize / 2
      const cy = pacman.py * tileSize + tileSize / 2
      const r = tileSize / 2 - 4
      const mouth = (Math.abs(Math.sin(pacman.angle)) * Math.PI) / 5
      let rotation = 0
      if (pacman.direction === "right") rotation = 0
      else if (pacman.direction === "left") rotation = Math.PI
      else if (pacman.direction === "up") rotation = -Math.PI / 2
      else if (pacman.direction === "down") rotation = Math.PI / 2
      ctx.save()
      ctx.translate(cx, cy)
      ctx.rotate(rotation)
      ctx.beginPath()
      ctx.moveTo(0, 0)
      ctx.arc(0, 0, r, mouth, 2 * Math.PI - mouth)
      ctx.lineTo(0, 0)
      ctx.fillStyle = "#d4c05a"
      ctx.shadowColor = "#d4c05a"
      ctx.shadowBlur = 8
      ctx.fill()
      ctx.restore()
    }

    function placeFruit() {
      let fx, fy
      do {
        fx = Math.floor(Math.random() * cols)
        fy = Math.floor(Math.random() * rows)
      } while (maze[fy][fx] === 1 || (fx === pacman.x && fy === pacman.y))
      fruit = { x: fx, y: fy }
    }

    function drawFruit() {
      if (!fruit) return
      const fx = fruit.x * tileSize + tileSize / 2
      const fy = fruit.y * tileSize + tileSize / 2
      const radius = tileSize / 7

      ctx.fillStyle = "yellow"
      ctx.beginPath()
      ctx.arc(fx, fy, radius, 0, Math.PI * 2)
      ctx.fill()
    }

    function drawMaze() {
      for (let y = 0; y < rows; y++) {
        for (let x = 0; x < cols; x++) {
          if (maze[y][x] === 1) {
            if (rgbMode) {
              mazeColor = `hsla(${(rgbHue + (x + y) * 10) % 360}, 90%, 55%, 0.15)`
            } else {
              mazeColor = baseMazeColor
            }
            ctx.fillStyle = mazeColor
            ctx.fillRect(x * tileSize, y * tileSize, tileSize, tileSize)
          }
        }
      }
    }

    function updateRgbHue() {
      if (rgbMode) {
        rgbHue = (rgbHue + 2) % 360
      }
    }

    function resize() {
      width = canvas.width = window.innerWidth
      height = canvas.height = window.innerHeight
      tileSize = calculateTileSize()

      cols = Math.floor(width / tileSize)
      rows = Math.floor(height / tileSize)
      halfCols = Math.floor(cols / 2)

      generateClassicMaze()

      particles = []
      const particleCount = Math.floor((width * height) / 12000)
      for (let i = 0; i < particleCount; i++) {
        particles.push(new Particle())
      }
    }

    function draw() {
      ctx.clearRect(0, 0, width, height)

      drawMaze()

      for (const p of particles) {
        p.update()
        p.draw()
      }

      updatePacman()
      drawPacman()
      drawFruit()
      updateRgbHue()

      requestAnimationFrame(draw)
    }

    resize()
    placeFruit()
    draw()

    window.addEventListener("resize", () => {
      resize()
      placeFruit()
    })
  }
}

// Section animations
function animateOnScroll() {
  const elements = document.querySelectorAll(".animated-section")
  if (!elements.length) return

  elements.forEach((element) => {
    const elementTop = element.getBoundingClientRect().top
    const elementVisible = 150

    if (elementTop < window.innerHeight - elementVisible) {
      element.classList.add("animate")
    }
  })
}

document.addEventListener("DOMContentLoaded", () => {
  const sections = document.querySelectorAll(".animated-section")

  const effects = ["effect-car-left", "effect-car-top"]

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          const section = entry.target
          const content = section.querySelector(".animated-content")

          if (content && !content.classList.contains("animated")) {
            const randomEffect = effects[Math.floor(Math.random() * effects.length)]
            section.classList.add(randomEffect)
            content.classList.add("animated")
          }

          observer.unobserve(section)
        }
      })
    },
    {
      threshold: 0.4,
    },
  )

  sections.forEach((section) => observer.observe(section))
})

const animatedContent2 = document.querySelectorAll(".animated-content2")

const observer2 = new IntersectionObserver(
  (entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add("show")
        observer2.unobserve(entry.target)
      }
    })
  },
  {
    threshold: 0.1,
  },
)

animatedContent2.forEach((element) => {
  observer2.observe(element)
})

// Partner channels carousel
const partnerData = [
  {
    name: "Defenestrando Jogos",
    url: "https://www.youtube.com/@defenestrandojogos",
    img: "/assets/images/partnerch/defenestrando.webp",
  },
  {
    name: "Canal Maddrugamers",
    url: "https://www.youtube.com/@maddrugamers",
    img: "/assets/images/partnerch/maddrugamers.webp",
  },
  {
    name: "Direto dos Consoles",
    url: "https://www.youtube.com/@DiretodosConsoles",
    img: "/assets/images/partnerch/diretodosconsoles.webp",
  },
  {
    name: "Retrozera",
    url: "https://www.youtube.com/@Retrozera",
    img: "/assets/images/partnerch/retrozera.webp",
  },
  {
    name: "Detona Bits",
    url: "https://www.youtube.com/@Detonabits",
    img: "/assets/images/partnerch/detonabits.webp",
  },
  {
    name: "Alan Joga+",
    url: "https://www.youtube.com/@alan.jogamais",
    img: "/assets/images/partnerch/jogamais.webp",
  },
  {
    name: "Gameplay Br",
    url: "https://www.youtube.com/@gameplaybr1746",
    img: "/assets/images/partnerch/gameplaybr.webp",
  },
  {
    name: "GuaxaZX",
    url: "https://www.youtube.com/@GuaxaZX",
    img: "/assets/images/partnerch/guaxazx.webp",
  },
  {
    name: "Nostal GAMES Retro",
    url: "https://www.youtube.com/@nostalgamesretro",
    img: "/assets/images/partnerch/nostalgamesretro.webp",
  },
  {
    name: "Jana Gamer",
    url: "https://www.youtube.com/@JanaGamer",
    img: "/assets/images/partnerch/janagamer.webp",
  },
  {
    name: "Anielleom",
    url: "https://www.youtube.com/@anielleom",
    img: "/assets/images/partnerch/anielleom.webp",
  },
  {
    name: "Mina dos Games (Amanda Nicoly)",
    url: "https://www.youtube.com/@minadosgamesamandanicoly6493",
    img: "/assets/images/partnerch/minadosgames.webp",
  },
  {
    name: "Attomic Games TV",
    url: "https://www.youtube.com/@Attomicgames",
    img: "/assets/images/partnerch/attomicgames.webp",
  },
  {
    name: "OpassadoRecentedosGames",
    url: "https://www.youtube.com/@OpassadoRecenteDosGames",
    img: "/assets/images/partnerch/opassadorecente.webp",
  },
  {
    name: "Gorilas Sisters",
    url: "https://www.youtube.com/@GorilasSisters",
    img: "/assets/images/partnerch/gorilassisters.webp",
  },
  {
    name: "Games das antigas",
    url: "https://www.youtube.com/@Gamesdasantigas",
    img: "/assets/images/partnerch/gamesdasantigas.webp",
  },
  {
    name: "MiRiNiOR GAMES",
    url: "https://www.youtube.com/@MiRiNiOR",
    img: "/assets/images/partnerch/miriniorgames.webp",
  },
  {
    name: "Fernando Lucas",
    url: "https://www.youtube.com/@fernando_lcs",
    img: "/assets/images/partnerch/fernandolucas.webp",
  },
  {
    name: "Toloi Games",
    url: "https://www.youtube.com/@ToloiGames",
    img: "/assets/images/partnerch/toloigames.webp",
  },
  {
    name: "Creative Games",
    url: "https://www.youtube.com/@CreativeGamesOficial",
    img: "/assets/images/partnerch/creativegames.webp",
  },
]

const container2 = document.querySelector(".channel-carousel-container")
const track2 = document.querySelector(".channel-carousel-track")

if (container2 && track2) {
  function shuffleArray(array) {
    return array.sort(() => Math.random() - 0.5)
  }

  function createSlides() {
    const shuffled = shuffleArray([...partnerData])
    const slides = shuffled.map((data) => {
      const div = document.createElement("div")
      div.className = "channel-slide"
      div.innerHTML = `
        <a href="${data.url}" target="_blank">
          <img src="${data.img}" alt="${data.name}">
          <p>${data.name}</p>
        </a>
      `
      return div
    })

    slides.forEach((slide) => track2.appendChild(slide))
    slides.forEach((slide) => track2.appendChild(slide.cloneNode(true)))
  }

  createSlides()

  let scrollSpeed = 0.5
  let scrollDirection = 1

  function animateScroll() {
    container2.scrollLeft += scrollSpeed * scrollDirection

    if (container2.scrollLeft >= track2.scrollWidth / 2) {
      container2.scrollLeft = 0
    } else if (container2.scrollLeft <= 0) {
      container2.scrollLeft = track2.scrollWidth / 2
    }

    requestAnimationFrame(animateScroll)
  }

  animateScroll()

  function updateScrollSpeed(x) {
    const width = container2.offsetWidth
    const left = width * 0.2
    const right = width * 0.8

    if (x < left) {
      scrollDirection = -1
      scrollSpeed = 1.5
    } else if (x > right) {
      scrollDirection = 1
      scrollSpeed = 1.5
    } else {
      scrollDirection = 1
      scrollSpeed = 0.5
    }
  }

  container2.addEventListener("mousemove", (e) => updateScrollSpeed(e.clientX))
  container2.addEventListener("touchmove", (e) => {
    if (e.touches.length > 0) updateScrollSpeed(e.touches[0].clientX)
  })
}

// YouTube integration
if (typeof spocky_vars !== "undefined") {
  if (document.getElementById("indexvideo-feed")) {
    loadYouTubeVideos()
  }

  if (document.getElementById("subscriber-count")) {
    loadChannelStats()
  }

  if (document.getElementById("liveplayer-video")) {
    loadLiveStream()
  }
}

function loadYouTubeVideos() {
  fetch(spocky_vars.ajax_url + "?action=spocky_youtube_data&youtube_action=videos&count=3")
    .then((response) => response.json())
    .then((data) => {
      if (data.success && data.data) {
        const container = document.getElementById("indexvideo-feed")
        container.innerHTML = ""

        data.data.forEach((video) => {
          const videoEl = document.createElement("div")
          videoEl.className = "indexvideo-item"
          videoEl.innerHTML = `
            <lite-youtube 
              videoid="${video.id}" 
              playlabel="${video.title.replace(/"/g, "'")}">
            </lite-youtube>
            <div class="indexvideo-title-text">${video.title}</div>
          `
          container.appendChild(videoEl)
        })
      }
    })
    .catch((error) => {
      console.error("Error loading YouTube videos:", error)
    })
}

function loadChannelStats() {
  fetch(spocky_vars.ajax_url + "?action=spocky_youtube_data&youtube_action=channel")
    .then((response) => response.json())
    .then((data) => {
      if (data.success && data.data) {
        const stats = data.data.statistics

        animateCount("subscriber-count", Number.parseInt(stats.subscriberCount), "+")
        animateCount("view-count", Number.parseInt(stats.viewCount), "+")
        animateCount("video-count", Number.parseInt(stats.videoCount), "+")

        const creationDate = new Date(spocky_vars.channel_creation_date || "2022-11-15")
        const now = new Date()
        const ageText = calculateChannelAge(creationDate, now)
        const ageEl = document.getElementById("statNumber")
        if (ageEl) animateAgeText(ageText, ageEl)
      }
    })
    .catch((error) => {
      console.error("Error loading channel stats:", error)
    })
}

function loadLiveStream() {
  fetch(spocky_vars.ajax_url + "?action=spocky_youtube_data&youtube_action=live")
    .then((response) => response.json())
    .then((data) => {
      if (data.success && data.data) {
        const liveData = data.data

        document.getElementById("liveplayer-title").textContent = liveData.title
        document.getElementById("liveplayer-video").innerHTML = `
          <lite-youtube 
            videoid="${liveData.id}" 
            playlabel="${liveData.title.replace(/"/g, "'")}">
          </lite-youtube>
        `

        const buttonsEl = document.getElementById("liveplayer-buttons")
        if (buttonsEl) {
          buttonsEl.innerHTML = `
            <a href="https://www.youtube.com/watch?v=${liveData.id}" target="_blank">Ver no YouTube</a>
            <a href="https://www.youtube.com/channel/${spocky_vars.youtube_channel_id}/join" target="_blank">Seja Membro</a>
          `
          buttonsEl.style.display = "flex"
        }

        const chatEl = document.getElementById("liveplayer-chat")
        if (chatEl && liveData.is_live) {
          chatEl.style.display = "block"
          chatEl.innerHTML = `
            <iframe 
              src="https://www.youtube.com/live_chat?v=${liveData.id}&embed_domain=${window.location.hostname}" 
              allowfullscreen style="width:100%;height:400px;border:none;"></iframe>`
        } else if (chatEl) {
          chatEl.style.display = "none"
        }
      }
    })
    .catch((error) => {
      console.error("Error loading live stream:", error)
    })
}

function animateCount(id, end, suffix = "", duration = 2000) {
  const el = document.getElementById(id)
  if (!el) return

  const start = 0
  const startTime = performance.now()
  const step = (timestamp) => {
    const progress = Math.min((timestamp - startTime) / duration, 1)
    const value = Math.floor(progress * end)
    el.textContent = value.toLocaleString() + suffix
    if (progress < 1) {
      requestAnimationFrame(step)
    } else {
      el.textContent = end.toLocaleString() + suffix
    }
  }
  requestAnimationFrame(step)
}

function animateAgeText(text, el) {
  el.textContent = ""
  let i = 0
  const interval = setInterval(() => {
    el.textContent += text[i]
    i++
    if (i >= text.length) clearInterval(interval)
  }, 50)
}

function calculateChannelAge(creationDate, currentDate) {
  let years = currentDate.getFullYear() - creationDate.getFullYear()
  let months = currentDate.getMonth() - creationDate.getMonth()
  let days = currentDate.getDate() - creationDate.getDate()

  if (days < 0) {
    months--
    const lastDayOfPrevMonth = new Date(currentDate.getFullYear(), currentDate.getMonth(), 0).getDate()
    days += lastDayOfPrevMonth
  }

  if (months < 0) {
    years--
    months += 12
  }

  return `${years} anos ${months} meses e ${days} dias`
}

// Forms handling
function initializeForms() {
  const contactForm = document.getElementById("contactForm")
  if (contactForm) {
    contactForm.addEventListener("submit", handleContactForm)
  }

  const newsletterForm = document.getElementById("newsletterForm")
  if (newsletterForm) {
    newsletterForm.addEventListener("submit", handleNewsletterForm)
  }
}

function handleContactForm(e) {
  e.preventDefault()

  const formData = new FormData(this)
  const submitButton = this.querySelector('button[type="submit"]')
  const originalText = submitButton.textContent

  submitButton.disabled = true
  submitButton.textContent = "Enviando..."

  fetch(spocky_vars.ajax_url, {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        showMessage("Mensagem enviada com sucesso!", "success")
        this.reset()
      } else {
        showMessage("Erro ao enviar mensagem. Tente novamente.", "error")
      }
    })
    .catch((error) => {
      showMessage("Erro ao enviar mensagem. Tente novamente.", "error")
    })
    .finally(() => {
      submitButton.disabled = false
      submitButton.textContent = originalText
    })
}

function handleNewsletterForm(e) {
  e.preventDefault()

  const formData = new FormData(this)
  const submitButton = this.querySelector('button[type="submit"]')
  const originalText = submitButton.textContent

  submitButton.disabled = true
  submitButton.textContent = "Cadastrando..."

  fetch(spocky_vars.ajax_url, {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        showMessage("Email cadastrado com sucesso!", "success")
        this.reset()
      } else {
        showMessage("Erro ao cadastrar email. Tente novamente.", "error")
      }
    })
    .catch((error) => {
      showMessage("Erro ao cadastrar email. Tente novamente.", "error")
    })
    .finally(() => {
      submitButton.disabled = false
      submitButton.textContent = originalText
    })
}

function showMessage(message, type) {
  const messageDiv = document.createElement("div")
  messageDiv.className = `form-${type}`
  messageDiv.textContent = message

  const form = document.querySelector("form")
  if (form) {
    form.insertBefore(messageDiv, form.firstChild)

    setTimeout(() => {
      messageDiv.remove()
    }, 5000)
  }
}

document.addEventListener("DOMContentLoaded", () => {
  initializeForms()
})
