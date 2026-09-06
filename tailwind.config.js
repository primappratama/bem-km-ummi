/** @type {import('tailwindcss').Config} */
module.exports = {
    content: ["./resources/**/*.blade.php", "./resources/**/*.js"],
    safelist: [
        "bg-teal-50",
        "bg-teal-600",
        "hover:bg-teal-700",
        "text-teal-600",
        "border-teal-100",
        "border-teal-400",
        "focus:border-teal-400",
        "ring-teal-500/20",
        "bg-green-50",
        "border-green-200",
        "text-green-500",
        "text-green-700",
    ],
    theme: {
        extend: {
            colors: {
                navy: "#102A52",
                red: "#E31E30",
                orange: "#F0871E",
                maroon: "#690000",
                ink: "#1A1A2E",
                mist: "#F5F7FF",
            },
            animation: {
                "float-a": "floatA 14s ease-in-out infinite",
                "float-b": "floatB 10s ease-in-out infinite",
                "float-c": "floatA 18s ease-in-out infinite reverse",
            },
            keyframes: {
                floatA: {
                    "0%,100%": { transform: "translateY(0px) translateX(0px)" },
                    "33%": { transform: "translateY(-28px) translateX(14px)" },
                    "66%": { transform: "translateY(10px) translateX(-18px)" },
                },
                floatB: {
                    "0%,100%": { transform: "translateY(0px) translateX(0px)" },
                    "33%": { transform: "translateY(20px) translateX(-12px)" },
                    "66%": { transform: "translateY(-14px) translateX(16px)" },
                },
            },
        },
    },
    plugins: [],
};
